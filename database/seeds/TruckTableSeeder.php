<?php

use Illuminate\Database\Seeder;

class TruckTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('truck')->insert([
            'no_polisi' => "F2241AZ",
            'jenis_kendaraan' => 'Terbuka',
            'perusahaan_transporter' => 'PT Ciwaruga Mandiri',
            'jenis_kode_limbah'	=> 'gapuh',
            'jalur_kendaraan'	=> 'naon deui ieu',
            'berat_maksimum_kendaraan'	=> 2000,
            'berat_limbah_dapat_diangkut' => 9000,
        ],
        [
            'no_polisi' => "F9821AC",
            'jenis_kendaraan' => 'Tertutup',
            'perusahaan_transporter' => 'PT Sarijadi Bersatu',
            'jenis_kode_limbah'	=> 'teu apal',
            'jalur_kendaraan'	=> 'naon deui ieu',
            'berat_maksimum_kendaraan'	=> 3234,
            'berat_limbah_dapat_diangkut' => 2111,
        ],
        );

    // factory(\App\Truck::class, 3)->create();

    }
}
