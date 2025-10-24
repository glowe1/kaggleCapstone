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
        Schema::table('vital_signs', function (Blueprint $table) {
            // Add comprehensive vital signs fields
            $table->date('measurement_date')->after('id');
            $table->integer('systolic')->nullable()->after('measurement_date');
            $table->integer('diastolic')->nullable()->after('systolic');
            $table->decimal('temperature', 5, 2)->nullable()->after('diastolic');
            $table->integer('pulse')->nullable()->after('temperature');
            $table->integer('oxygen_saturation')->nullable()->after('pulse');
            $table->integer('pain_level')->nullable()->after('oxygen_saturation');
            $table->string('pain_description')->nullable()->after('pain_level');
            $table->text('reason_declined')->nullable()->after('pain_description');
            $table->enum('status', ['approved', 'pending_review', 'declined', 'critical'])->default('pending_review')->after('reason_declined');
            $table->text('notes')->nullable()->after('status');
            $table->foreignId('taken_by')->nullable()->constrained('users')->after('notes');
            
            // Add foreign key constraints
            $table->foreignId('resident_id')->constrained()->after('taken_by');
            $table->foreignId('branch_id')->constrained()->after('resident_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vital_signs', function (Blueprint $table) {
            $table->dropForeign(['taken_by']);
            $table->dropForeign(['resident_id']);
            $table->dropForeign(['branch_id']);
            
            $table->dropColumn([
                'measurement_date',
                'systolic',
                'diastolic', 
                'temperature',
                'pulse',
                'oxygen_saturation',
                'pain_level',
                'pain_description',
                'reason_declined',
                'status',
                'notes',
                'taken_by',
                'resident_id',
                'branch_id'
            ]);
        });
    }
};
