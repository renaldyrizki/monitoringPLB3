<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mouControl extends Model
{
    protected $table = 'mou_control';

    protected $primaryKey = 'id_mou';

    protected $dates = [
        'tanggal_kontrak_perusahaan',
        'tanggal_habis_berlaku_perusahaan',
        'tanggal_terbit_kontrak',
        'tanggal_habis_berlaku_kontrak'
    ];

    protected $fillable = [
        'id_mou',
        'perusahaan_pengelola_lanjut',
        'status_kontrak',
        'tipe_pengelolaan',
        'jenis_limbah',
        'surat_pernyataan_tidak_masalah',
        'nomor_izin_perusahaan',
        'tanggal_kontrak_perusahaan',
        'tanggal_habis_berlaku_perusahaan',
        'lampiran_perusahaan',
        'nomor_kontrak',
        'tanggal_terbit_kontrak',
        'tanggal_habis_berlaku_kontrak',
        'lampiran_kontrak',
    ];
}