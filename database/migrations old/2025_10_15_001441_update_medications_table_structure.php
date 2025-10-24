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
        Schema::table('medications', function (Blueprint $table) {
            // Add new columns
            $table->string('instructions')->nullable()->after('name');
            $table->integer('quantity')->nullable()->after('instructions');
            $table->text('diagnosis')->nullable()->after('quantity');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null')->after('diagnosis');
            $table->date('prescription_date')->nullable()->after('created_by');
            $table->date('start_date')->nullable()->after('prescription_date');
            $table->date('end_date')->nullable()->after('start_date');
            $table->text('notes')->nullable()->after('end_date');
            $table->boolean('is_active')->default(true)->after('notes');
            
            // Add soft deletes
            $table->softDeletes();
            
            // Add indexes
            $table->index(['resident_id', 'is_active']);
            $table->index(['created_by', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medications', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropIndex(['resident_id', 'is_active']);
            $table->dropIndex(['created_by', 'is_active']);
            $table->dropColumn([
                'instructions', 'quantity', 'diagnosis', 'created_by',
                'prescription_date', 'start_date', 'end_date', 'notes', 'is_active', 'deleted_at'
            ]);
        });
    }
};
