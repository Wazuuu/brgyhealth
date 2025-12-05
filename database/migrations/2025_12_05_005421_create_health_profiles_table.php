<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Existing fields
            $table->string('blood_type');
            $table->json('allergies')->nullable();
            $table->boolean('critical_allergies')->default(false);
            $table->string('status')->default('Active');
            $table->string('clearance')->default('Pending');
            $table->date('last_verified')->nullable();

            // Contact Info
            $table->string('philhealth_number')->nullable();
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone');

            // --- NEW FIELDS ---
            $table->integer('age')->nullable();
            $table->decimal('height', 5, 2)->nullable(); // Stored in cm
            $table->decimal('weight', 5, 2)->nullable(); // Stored in kg
            $table->decimal('bmi', 5, 2)->nullable();    // Calculated

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_profiles');
    }
};