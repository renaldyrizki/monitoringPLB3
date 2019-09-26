<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenyimpananLimbahTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penyimpanan_limbah', function (Blueprint $table) {
            $table->increments('id_penyimpanan');
            $table->string('jenis_limbah');
            $table->date('tanggal_penyimpanan');
            $table->date('tanggal_expired');
            $table->string('sumber_limbah');
            $table->integer('total_penyimpanan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penyimpanan_limbah');
    }
}
