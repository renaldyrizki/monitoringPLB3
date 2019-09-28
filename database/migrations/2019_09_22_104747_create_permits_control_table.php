<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermitsControlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permits_control', function (Blueprint $table) {
            $table->increments('id_permits');
            $table->string('jenis_perizinan');
            $table->string('nama_perusahaan');
            $table->boolean('status_izin');
            $table->string('dikeluarkan_oleh');
            $table->string('no_surat_keputusan')->unique();
            $table->date('tanggal_terbit');
            $table->date('tanggal_habis_berlaku');
            $table->string('lampiran_dokumen')->nullable();
            $table->integer('plant_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permits_control');
    }
}
