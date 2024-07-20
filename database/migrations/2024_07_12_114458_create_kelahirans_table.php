<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelahiransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelahirans', function (Blueprint $table) {
            $table->id('kelahiran_id');
            $table->string('nik', 50);
            $table->string('nik_ibu', 50);
            $table->string('nik_ayah', 50);
            $table->string('alamat_kelahiran', 50);
            $table->string('nama_anak', 200);
            $table->date('tgl_lahir');
            $table->string('anak_ke', 200);
            $table->timestamps();

            $table->foreign('nik')->references('nik')->on('penduduks')->onDelete('cascade');
            $table->foreign('nik_ibu')->references('nik')->on('penduduks')->onDelete('cascade');
            $table->foreign('nik_ayah')->references('nik')->on('penduduks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelahirans');
    }
}
