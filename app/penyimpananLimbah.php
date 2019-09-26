<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class penyimpananLimbah extends Model
{
    // use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'penyimpanan_limbah';

    protected $primaryKey = 'id_penyimpanan';

    public $timestamps = false;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = ['tanggal_penyimpanan'
    // ];

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
        'id_penyimpanan',
        'jenis_limbah',
        'tanggal_penyimpanan',
        'masa_simpan',
        'sumber_limbah',
        'total_penyimpanan',
    ];
}
