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
            $table->foreignId('drug_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name')->nullable()->change(); // Make name nullable since we'll use drug relationship
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medications', function (Blueprint $table) {
            $table->dropForeign(['drug_id']);
            $table->dropColumn('drug_id');
            $table->string('name')->nullable(false)->change();
        });
    }
};