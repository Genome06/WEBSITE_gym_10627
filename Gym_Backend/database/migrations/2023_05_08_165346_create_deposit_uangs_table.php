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
        Schema::create('deposit_uangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_member');
            $table->foreign('id_member')->references('id')->on('members')->onDelete('cascade');
            $table->unsignedBigInteger('id_kasir');
            $table->foreign('id_kasir')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_promo')->nullable();
            $table->foreign('id_promo')->references('id')->on('promos')->onDelete('cascade');
            $table->dateTime('waktu')->nullable();
            $table->integer('biaya_deposit')->nullable();
            $table->string('no_deposit')->nullable();
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
        Schema::dropIfExists('deposit_uangs');
    }
};
