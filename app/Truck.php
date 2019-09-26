<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Truck extends Model
{
    // use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'truck';

    protected $primaryKey = 'id_truck';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    public $timestamps = false;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    // public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'no_polisi',
        'jenis_kendaraan',
        'perusahaan_transporter',
        'jenis_kode_limbah',
        'jalur_kendaraan',
        'berat_maksimum_kendaraan',
        'berat_limbah_dapat_diangkut',
        'izin_pengangkutan_tanggal_terbit', 'izin_pengangkutan_tanggal_habis',
        'dokumen_lingkungan_tanggal_terbit', 'dokumen_lingkungan_tanggal_habis',
        'mou_tanggal_terbit', 'mou_tanggal_habis',
        'kartu_pengawasan_tanggal_terbit', 'kartu_pengawasan_tanggal_habis',
    ];
}
