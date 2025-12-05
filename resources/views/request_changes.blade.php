@extends('layouts.welcome')

@section('title', 'Health Records & Requests | Barangay Health System')

@section('content')

    <div class="max-w-7xl mx-auto">
        
        <h2 class="text-4xl font-extrabold text-gray-800 mb-8">
            🏥 Your Personal Health Records
        </h2>

        <!-- Health Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Mock Data is pulled from the Controller's $healthRecord variable -->

            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-blue-500 hover:shadow-xl transition duration-150">
                <h3 class="text-gray-500 text-sm font-medium uppercase flex items-center">
                    Blood Type 
                </h3>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $healthRecord['blood_type'] ?? 'N/A' }}</p>
                <span class="text-xs text-gray-500">Last Verified: {{ $healthRecord['last_verified'] ?? 'N/A' }}</span>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-pink-500 hover:shadow-xl transition duration-150">
                <h3 class="text-gray-500 text-sm font-medium uppercase flex items-center">
                    Known Allergies
                </h3>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ count($healthRecord['allergies']) }}</p>
                <span class="text-xs text-gray-500">Critical Allergies? {{ $healthRecord['critical_allergies'] ? 'Yes' : 'No' }}</span>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500 hover:shadow-xl transition duration-150">
                <h3 class="text-gray-500 text-sm font-medium uppercase flex items-center">
                    Resident Status
                </h3>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $healthRecord['status'] ?? 'Active' }}</p>
                <span class="text-xs text-gray-500">Brgy. Clearance: {{ $healthRecord['clearance'] ?? 'Valid' }}</span>
            </div>
        </div>

        <!-- Detailed Records Table -->
        <div class="bg-white p-8 rounded-xl shadow-2xl mb-12 border-t-4 border-gray-400">
            <h3 class="text-2xl font-semibold text-gray-700 mb-4">Immunization & Health History</h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">
                                Record Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Details
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-lg">
                                Doctor/Clinic
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($healthRecord['history'] as $record)
                            <tr class="hover:bg-gray-50 transition duration-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $record['date'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($record['type'] == 'Immunization') 
                                        @elseif($record['type'] == 'Check-up') 
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $record['type'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $record['details'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record['clinic'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 italic">No health history records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- CHANGE REQUEST FORM SECTION -->
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b pb-2 pt-4 mt-12">
            ✏️ Submit a Change or Correction Request
        </h2>

        <div class="bg-white p-8 rounded-xl shadow-2xl mb-12 border-t-4 border-pink-500">
            <h3 class="text-xl font-semibold text-gray-700 mb-6">Request Form</h3>
            
            <form id="change-request-form">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Type of Request -->
                    <div>
                        <label for="requestType" class="block text-sm font-medium text-gray-700 mb-1">Type of Change Required</label>
                        <select id="requestType" name="requestType" required
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500 transition duration-150">
                            <option value="" disabled selected>Select category</option>
                            <option value="Demographic">Demographic Data (Name, Address, Birthdate)</option>
                            <option value="Health">Health Record Update (Allergies, Status)</option>
                            <option value="History Correction">Health History Correction</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Required Document (Mock field) -->
                    <div>
                        <label for="document" class="block text-sm font-medium text-gray-700 mb-1">Attach Supporting Document (Optional)</label>
                        <input type="file" id="document" name="document"
                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 cursor-pointer">
                    </div>
                </div>

                <!-- Detailed Explanation Field -->
                <div class="mt-6">
                    <label for="details" class="block text-sm font-medium text-gray-700 mb-1">Detailed Explanation of Change</label>
                    <textarea id="details" name="details" rows="5" required
                              placeholder="Please explain exactly what needs to be changed and why. Include old and new values if applicable (e.g., Change surname from 'Dela Cruz' to 'Reyes' due to marriage)."
                              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500 transition duration-150"></textarea>
                </div>

                <!-- Confirmation Message Box -->
                <div id="message-box-request" class="mt-6 p-4 text-sm hidden rounded-lg" role="alert"></div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit" id="submit-request-button"
                            class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-200 transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-pink-500 focus:ring-opacity-50 disabled:bg-gray-400">
                        Submit Change Request
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Pending Requests Section -->
        <h3 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-2 pt-4 mt-6">📋 Your Pending Requests</h3>
        
        <div id="requests-list" class="space-y-4">
            <!-- Requests will be listed here -->
            <div class="p-6 bg-white rounded-xl shadow-lg text-gray-500 text-center" id="loading-indicator-request">
                Loading requests...
            </div>
        </div>
    </div>

    <!-- Firebase SDK and Script Section -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
        import { getAuth, signInAnonymously, signInWithCustomToken, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-auth.js";
        import { getFirestore, doc, addDoc, onSnapshot, collection, query, setLogLevel } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-firestore.js";

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
        const form = document.getElementById('change-request-form');
        const requestsList = document.getElementById('requests-list');
        const messageBox = document.getElementById('message-box-request');
        const submitButton = document.getElementById('submit-request-button');

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
                isAuthReady = true;
                console.log("User authenticated:", userId);
                
                // Start listening for requests once authenticated
                listenForRequests();

            } else {
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
                    isAuthReady = true;
                }
            }
        });

        // 3. Real-time Request Listener
        function listenForRequests() {
            if (!db || !userId) return;

            // Private data path for the logged-in user
            const path = `artifacts/${appId}/users/${userId}/change_requests`;
            const q = query(collection(db, path));
            
            console.log(`Listening to change requests at: ${path}`);

            onSnapshot(q, (snapshot) => {
                const requests = [];
                snapshot.forEach((doc) => {
                    const data = doc.data();
                    requests.push({
                        id: doc.id,
                        type: data.requestType,
                        details: data.details,
                        status: data.status || 'Pending',
                        submittedAt: data.submittedAt // This is a Timestamp
                    });
                });

                // Sort by submission time (newest first)
                requests.sort((a, b) => b.submittedAt.toDate() - a.submittedAt.toDate());
                
                renderRequests(requests);

            }, (error) => {
                console.error("Error listening to requests:", error);
                requestsList.innerHTML = `<div class="p-6 bg-red-100 text-red-800 rounded-xl shadow-lg">Error loading requests: ${error.message}</div>`;
            });
        }

        // 4. Render Requests to UI
        function renderRequests(requests) {
            requestsList.innerHTML = ''; // Clear previous list

            if (requests.length === 0) {
                requestsList.innerHTML = `
                    <div class="p-6 bg-gray-200 rounded-xl shadow border-l-4 border-gray-400 text-gray-700 text-center">
                        You have no outstanding change requests.
                    </div>
                `;
                return;
            }

            requests.forEach(req => {
                let statusColor;
                let statusText;
                
                if (req.status === 'Approved') {
                    statusColor = 'bg-green-100 text-green-800 border-green-500';
                    statusText = '✅ Approved';
                } else if (req.status === 'Rejected') {
                    statusColor = 'bg-red-100 text-red-800 border-red-500';
                    statusText = '❌ Rejected';
                } else {
                    statusColor = 'bg-yellow-100 text-yellow-800 border-yellow-500';
                    statusText = '⏳ Pending Review';
                }

                const requestHtml = `
                    <div class="p-6 bg-white rounded-xl shadow-lg border-l-4 ${statusColor}">
                        <div class="flex justify-between items-start mb-2">
                            <p class="text-lg font-bold text-gray-800">
                                Request Type: ${req.type}
                            </p>
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium ${statusColor} rounded-full">
                                ${statusText}
                            </span>
                        </div>
                        <p class="text-gray-600 mb-3 text-sm italic">
                            Submitted on: ${formatTimestamp(req.submittedAt)}
                        </p>
                        <p class="text-gray-700 mt-2 border-t pt-2">
                            Details: ${req.details}
                        </p>
                    </div>
                `;
                requestsList.innerHTML += requestHtml;
            });
        }

        // 5. Handle Form Submission
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            if (!isAuthReady || !userId) {
                showMessage("Authentication is not complete. Please wait and try again.", false);
                return;
            }

            submitButton.disabled = true;
            submitButton.textContent = 'Submitting...';

            const data = new FormData(form);
            const requestType = data.get('requestType');
            const details = data.get('details').trim();
            const submittedAt = new Date(); // Capture submission time
            // Document upload is mocked; we only save the metadata

            if (!requestType || !details) {
                showMessage("Please select a request type and provide details.", false);
                submitButton.disabled = false;
                submitButton.textContent = 'Submit Change Request';
                return;
            }
            
            try {
                // The collection is named 'change_requests' to differentiate from 'appointments'
                const colRef = collection(db, `artifacts/${appId}/users/${userId}/change_requests`);
                await addDoc(colRef, {
                    requestType,
                    details,
                    status: 'Pending', // Initial status
                    submittedAt
                });

                showMessage("Request successfully submitted! Check the list below for status updates.", true);
                form.reset(); 
            } catch (error) {
                console.error("Error submitting request:", error);
                showMessage(`Error submitting request: ${error.message}`, false);
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Submit Change Request';
            }
        });
    </script>
@endsection