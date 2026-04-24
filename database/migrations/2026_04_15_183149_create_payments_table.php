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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Kjo lidhet me 'book_id' sepse ashtu e ke emertuar primarin te tabela books
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->decimal('shuma', 8, 2);
            $table->string('metoda_pageses')->default('Kredit Kartel');
            $table->string('statusi')->default('e perfunduar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};