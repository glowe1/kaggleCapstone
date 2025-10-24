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
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('resident_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('healthcare_provider_id')->nullable()->constrained()->onDelete('set null');
            $table->date('appointment_date');
            $table->time('appointment_time')->nullable();
            $table->string('provider_name')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['scheduled', 'confirmed', 'in_progress', 'completed', 'cancelled', 'no_show', 'rescheduled'])->default('scheduled');
            $table->date('next_appointment_date')->nullable();
            $table->string('recurrence_pattern')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['resident_id']);
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['appointment_type_id']);
            $table->dropForeign(['healthcare_provider_id']);
            $table->dropForeign(['created_by']);
            $table->dropColumn([
                'resident_id',
                'branch_id',
                'appointment_type_id',
                'healthcare_provider_id',
                'appointment_date',
                'appointment_time',
                'provider_name',
                'location',
                'description',
                'status',
                'next_appointment_date',
                'recurrence_pattern',
                'notes',
                'created_by',
            ]);
        });
    }
};
