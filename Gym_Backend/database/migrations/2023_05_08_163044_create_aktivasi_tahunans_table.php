<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktivasi_tahunans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_member');
            $table->foreign('id_member')->references('id')->on('members')->onDelete('cascade');
            $table->unsignedBigInteger('id_kasir');
            $table->foreign('id_kasir')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('waktu')->nullable();
            $table->integer('biaya_aktivasi')->nullable();
            $table->date('masa_aktif')->nullable();
            $table->string('no_aktivasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aktivasi_tahunans');
    }
};
