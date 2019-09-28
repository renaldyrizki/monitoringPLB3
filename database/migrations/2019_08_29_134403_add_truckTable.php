<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTruckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck', function (Blueprint $table) {

            
            // $table->string('no_polisi')->index();
            // $table->string('jenis_kendaraan')->index();

            // $table->string('no_polisi');
            // $table->string('jenis_kendaraan');
            // $table->index(['account_id', 'created_at']);

            $table->increments('id_truck')->index();
            $table->string('no_polisi')->unique();
            $table->boolean('jenis_kendaraan');
            $table->string('perusahaan_transporter');
            $table->string('jenis_kode_limbah');
            $table->integer('berat_maksimum_kendaraan');
            $table->integer('berat_limbah_dapat_diangkut');
            //izinpengangkutan
            $table->string('izin_pengangkutan_nomor')->nullable();
            $table->date('izin_pengangkutan_tanggal_terbit')->nullable();
            $table->date('izin_pengangkutan_tanggal_habis')->nullable();
            $table->string('izin_pengangkutan_file')->nullable();
            //dokumenLingkungan
            $table->string('dokumen_lingkungan_nomor')->nullable();
            $table->date('dokumen_lingkungan_tanggal_terbit')->nullable();
            $table->date('dokumen_lingkungan_tanggal_habis')->nullable();
            $table->string('dokumen_lingkungan_file')->nullable();
            //mou
            $table->string('mou_nomor')->nullable();
            $table->date('mou_tanggal_terbit')->nullable();
            $table->date('mou_tanggal_habis')->nullable();
            $table->string('mou_file')->nullable();
            //kartuPengawasan
            $table->string('kartu_pengawasan_nomor')->nullable();
            $table->date('kartu_pengawasan_tanggal_terbit')->nullable();
            $table->date('kartu_pengawasan_tanggal_habis')->nullable();
            $table->string('kartu_pengawasan_file')->nullable();
            
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
        Schema::dropIfExists('truck');
    }
}
