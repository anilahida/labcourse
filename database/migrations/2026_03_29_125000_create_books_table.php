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
    Schema::disableForeignKeyConstraints();
    Schema::create('books', function (Blueprint $table) {
        $table->id(); // Ose thjesht $table->id(); varet si e ke lënë te Modeli
        $table->string('titulli');
        $table->text('pershkrimi')->nullable();
        $table->string('isbn')->unique();
        $table->decimal('cmimi', 8, 2);
        $table->integer('sasia');
        
        // Lidhjet me tabelat tjera (Foreign Keys)
      $table->foreignId('author_id')->constrained('authors')->onDelete('cascade');
      $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

        $table->timestamps();

    });
    Schema::enableForeignKeyConstraints();
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
