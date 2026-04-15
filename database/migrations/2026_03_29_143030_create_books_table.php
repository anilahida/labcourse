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
    Schema::create('books', function (Blueprint $table) {
        $table->id('book_id'); // Ose thjesht $table->id(); varet si e ke lënë te Modeli
        $table->string('titulli');
        $table->text('pershkrimi')->nullable();
        $table->string('isbn')->unique();
        $table->decimal('cmimi', 8, 2);
        $table->integer('sasia');
        
        // Lidhjet me tabelat tjera (Foreign Keys)
        $table->unsignedBigInteger('author_id');
        $table->unsignedBigInteger('category_id');

        $table->timestamps();

        // Deklarimi i lidhjeve (Opsionale por e rekomanduar)
        $table->foreign('author_id')->references('author_id')->on('authors')->onDelete('cascade');
        $table->foreign('category_id')->references('kategori_id')->on('categories')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
