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
        // Modify the categories table to add foreign key constraints
        Schema::table('categories', function (Blueprint $table) {
            // Add department_id as a foreign key
            $table->foreignId('department_id')->constrained()->onDelete('cascade');

            // Add parent_id as a foreign key referencing categories (self-referencing)
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the foreign key constraints if the migration is rolled back
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropForeign(['parent_id']);
        });
    }
};
