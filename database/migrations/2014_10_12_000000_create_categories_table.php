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

        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // PK sipas detyrës
            $table->string('emri');
            $table->text('pershkrimi')->nullable();
            
            // Kjo lejon që një kategori të ketë një "prind" (p.sh. "Roman" prind i "Thriller")
    
       $table->foreignId('kategoria_prind_id')
      ->nullable()
      ->constrained('categories')
      ->onDelete('cascade');
            
            $table->timestamps();
        });
        
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
