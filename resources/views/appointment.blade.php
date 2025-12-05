@extends('layouts.welcome')

@section('title', 'Make an Appointment | Barangay Clinic')

{{-- Since the layout includes the full structure, we only provide the main content inside the @section('content') --}}
@section('content')

    <div class="max-w-4xl mx-auto">
        
        <h2 class="text-4xl font-extrabold text-gray-800 mb-8">
            🏥 Clinic Appointment Booking
        </h2>

        <!-- Appointment Form Card -->
        <div class="bg-white p-8 rounded-xl shadow-2xl mb-12 border-t-4 border-blue-500">
            <h3 class="text-2xl font-semibold text-gray-700 mb-6">Schedule New Appointment</h3>
            
            <!-- Form with Firebase logic attached via script -->
            <form id="appointment-form">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date Field -->
                    <div>
                        <label for="appointmentDate" class="block text-sm font-medium text-gray-700 mb-1">Appointment Date</label>
                        <input type="date" id="appointmentDate" name="appointmentDate" required
                               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                    </div>

                    <!-- Time Field -->
                    <div>
                        <label for="appointmentTime" class="block text-sm font-medium text-gray-700 mb-1">Preferred Time</label>
                        <select id="appointmentTime" name="appointmentTime" required
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                            <option value="" disabled selected>Select a time slot</option>
                            <!-- Clinic Hours: 9:00 AM to 4:00 PM, 30-min intervals -->
                            <option value="09:00">09:00 AM</option>
                            <option value="09:30">09:30 AM</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="10:30">10:30 AM</option>
                            <option value="11:00">11:00 AM</option>
                            <option value="11:30">11:30 AM</option>
                            <option value="13:00">01:00 PM</option>
                            <option value="13:30">01:30 PM</option>
                            <option value="14:00">02:00 PM</option>
                            <option value="14:30">02:30 PM</option>
                            <option value="15:00">03:00 PM</option>
                            <option value="15:30">03:30 PM</option>
                            <option value="16:00">04:00 PM</option>
                        </select>
                    </div>
                </div>

                <!-- Reason Field -->
                <div class="mt-6">
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Visit</label>
                    <textarea id="reason" name="reason" rows="3" required
                              placeholder="e.g., Routine check-up, Cough and cold, Prenatal visit"
                              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150"></textarea>
                </div>

                <!-- Confirmation Message Box (Replaces alert()) -->
                <div id="message-box" class="mt-6 p-4 text-sm hidden rounded-lg" role="alert"></div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit" id="submit-button"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-200 transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 disabled:bg-gray-400">
                        Book Appointment
                    </button>
                </div>
            </form>
        </div>

        <!-- Existing Appointments Section -->
        <h3 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-2">📅 Your Scheduled Appointments</h3>
        
        <div id="appointments-list" class="space-y-4">
            <!-- Appointments will be listed here -->
            <div class="p-6 bg-white rounded-xl shadow-lg text-gray-500 text-center" id="loading-indicator">
                Loading appointments...
            </div>
        </div>

    </div>

    <!-- Firebase SDK and Script Section -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
        import { getAuth, signInAnonymously, signInWithCustomToken, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-auth.js";
        import { getFirestore, doc, addDoc, onSnapshot, collection, query, deleteDoc, setLogLevel } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-firestore.js";

        // IMPORTANT: Use the provided global variables for canvas environment
        const appId = typeof __app_id !== 'undefined' ? __app_id : 'default-app-id';
        const firebaseConfig = typeof __firebase_config !== 'undefined' ? JSON.parse(__firebase_config) : {};
        const initialAuthToken = typeof __initial_auth_token !== 'undefined' ? __initial_auth_token : null;

        // Global variables for Firebase services
        let app;
        let db;
        let auth;
        let userId = null;
        let isAuthReady = false;

        // UI elements
        const form = document.getElementById('appointment-form');
        const appointmentsList = document.getElementById('appointments-list');
        const userIdDisplay = document.getElementById('user-id-display');
        const messageBox = document.getElementById('message-box');
        const submitButton = document.getElementById('submit-button');

        // Helper to show custom message box
        function showMessage(text, isSuccess = true) {
            messageBox.textContent = text;
            messageBox.className = 'mt-6 p-4 text-sm rounded-lg';
            if (isSuccess) {
                messageBox.classList.add('bg-green-100', 'text-green-800');
            } else {
                messageBox.classList.add('bg-red-100', 'text-red-800');
            }
            messageBox.classList.remove('hidden');
            setTimeout(() => {
                messageBox.classList.add('hidden');
            }, 5000);
        }

        // 1. Initialize Firebase and Auth
        try {
            setLogLevel('Debug');
            app = initializeApp(firebaseConfig);
            db = getFirestore(app);
            auth = getAuth(app);
            console.log("Firebase Initialized.");
        } catch (error) {
            console.error("Firebase initialization error:", error);
            showMessage("Error initializing Firebase. Check console for details.", false);
        }

        /**
         * Converts Firestore timestamp object to a readable time string.
         * @param {Object} timestamp - Firestore Timestamp object
         * @returns {string} Formatted date and time string
         */
        function formatTimestamp(timestamp) {
            if (!timestamp || !timestamp.toDate) return 'N/A';
            const date = timestamp.toDate();
            const options = { 
                year: 'numeric', month: 'short', day: 'numeric', 
                hour: '2-digit', minute: '2-digit', 
                hour12: true 
            };
            return date.toLocaleString(undefined, options);
        }

        // 2. Authentication Listener
        onAuthStateChanged(auth, async (user) => {
            if (user) {
                userId = user.uid;
                // Since the Firestore ID display is in the layout sidebar (@auth block), we must check if it exists before updating it.
                const userIdDisplayEl = document.getElementById('user-id-display');
                if (userIdDisplayEl) {
                    userIdDisplayEl.textContent = userId;
                }
                isAuthReady = true;
                console.log("User authenticated:", userId);
                
                // Start listening for appointments once authenticated
                listenForAppointments();

            } else {
                // Since this is a Blade file for a logged-in user, we simulate login if not authed by the environment
                try {
                    if (initialAuthToken) {
                        await signInWithCustomToken(auth, initialAuthToken);
                        console.log("Signed in with custom token.");
                    } else {
                        await signInAnonymously(auth);
                        console.log("Signed in anonymously.");
                    }
                } catch (error) {
                    console.error("Authentication error:", error);
                    const userIdDisplayEl = document.getElementById('user-id-display');
                    if (userIdDisplayEl) {
                        userIdDisplayEl.textContent = "Auth Failed!";
                    }
                    isAuthReady = true;
                }
            }
        });

        // 3. Real-time