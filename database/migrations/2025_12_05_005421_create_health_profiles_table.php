<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
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

        // NEW FIELDS
        $table->string('philhealth_number')->nullable();
        $table->string('emergency_contact_name');
        $table->string('emergency_contact_phone');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_profiles');
    }
};
