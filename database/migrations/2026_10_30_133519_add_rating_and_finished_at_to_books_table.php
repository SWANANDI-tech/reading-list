<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Adds two optional columns to the books table
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->unsignedTinyInteger('rating')->nullable();   // 1 to 5 stars
            $table->date('finished_at')->nullable();             // day the book was finished
        });
    }

    // Undo: removes the two columns again
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['rating', 'finished_at']);
        });
    }
};