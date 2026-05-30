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
        Schema::table('shipping_addresses', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            $table->string('emri');
            $table->string('mbiemri');
            $table->string('rruga');
            $table->string('qyteti');
            $table->string('shteti')->default('Kosovë');
            $table->string('kodi_postar')->nullable();
            $table->string('telefoni')->nullable();
            $table->boolean('default')->default(false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('shipping_addresses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id','emri','mbiemri','rruga','qyteti','shteti','kodi_postar','telefoni','default']);
        });
    }
};
