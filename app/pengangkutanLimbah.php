<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class pengangkutanLimbah extends Model
{
    // use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengangkutan_limbah';

    protected $primaryKey = 'id_pengangkutan';

    public $timestamps = false;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = ['tanggal_pengangkutan'];

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
        'id_pengangkutan',
        'jenis_limbah',
        'tanggal_pengangkutan',
        'total_pengangkutan',
        'nomor_manifest',
        'perusahaan_pengangkut',
        'tujuan_pemanfaatan',
    ];
}
