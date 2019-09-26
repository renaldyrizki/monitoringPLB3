<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengangkutanLimbahTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengangkutan_limbah', function (Blueprint $table) {
            $table->increments('id_pengangkutan');
            $table->string('jenis_limbah');
            $table->date('tanggal_pengangkutan');
            $table->integer('total_pengangkutan');
            $table->string('nomor_manifest');
            $table->string('perusahaan_pengangkut');
            $table->string('tujuan_pemanfaatan');
            $table->boolean('status_pengangkutan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengangkutan_limbah');
    }
}
