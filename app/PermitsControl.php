<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
// use App\Filters\Filterable;


class PermitsControl extends Model
{
    // use Filterable;

    protected $table = 'permits_control';

    protected $primaryKey = 'id_permits';

    public $timestamps = false;

    protected $fillable = [
        'id_permits',
        'jenis_perizinan',
        'nama_perusahaan',
        'status_izin',
        'tanggal_terbit',
        'tanggal_habis_berlaku',
        'dikeluarkan_oleh',
        'no_surat_keputusan',
        'lampiran_dokumen',
    ];
}
