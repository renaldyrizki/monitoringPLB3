<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMouTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mou_control', function (Blueprint $table) {
            $table->increments('id_mou');
            $table->string('perusahaan_pengelola_lanjut');
            $table->boolean('status_kontrak');
            $table->string('tipe_pengelolaan');
            $table->string('jenis_limbah');
            $table->string('surat_pernyataan_tidak_masalah');
            $table->string('nomor_izin_perusahaan');
            $table->date('tanggal_kontrak_perusahaan');
            $table->date('tanggal_habis_berlaku_perusahaan');
            $table->string('lampiran_perusahaan');
            $table->string('nomor_kontrak')->unique();
            $table->date('tanggal_terbit_kontrak');
            $table->date('tanggal_habis_berlaku_kontrak');
            $table->string('lampiran_kontrak');
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
        Schema::dropIfExists('mou_control');
    }
}
