<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->string('status')->default('Active')->after('is_sick'); // Active, Archived
            $table->string('blood_type')->nullable()->after('status');
            $table->text('allergies')->nullable()->after('blood_type');
            $table->string('contact_number')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->dropColumn(['status', 'blood_type', 'allergies', 'contact_number']);
        });
    }
};