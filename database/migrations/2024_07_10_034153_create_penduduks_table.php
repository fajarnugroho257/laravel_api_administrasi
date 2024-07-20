<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenduduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penduduks', function (Blueprint $table) {
            $table->string('nik', 50)->primary();
            $table->string('no_kk', 50);
            $table->bigInteger('profesi_id')->unsigned();
            $table->string('nama_lengkap', 100);
            $table->string('tempat_lahir', 255);
            $table->string('alamat', 255);
            $table->date('tgl_lahir');
            $table->string('agama', 100);
            $table->string('kewarganegaraan', 150);
            $table->enum('jk', ['L', 'P']);
            $table->enum('status', ['aktif', 'nonaktif']);
            $table->timestamps();

            $table->foreign('no_kk')->references('no_kk')->on('kartukeluargas')->onDelete('cascade');
            $table->foreign('profesi_id')->references('profesi_id')->on('profesis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penduduks');
    }
}
