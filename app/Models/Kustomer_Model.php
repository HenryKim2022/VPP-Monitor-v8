<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kustomer_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_client';
    protected $primaryKey = 'id_client';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'id_client',
        'na_client',
        'alamat_client',
        'notelp_client',
        'foto_client'
    ];

    public function daftar_login()
    {
        return $this->belongsTo(DaftarLogin_Model::class, 'id_client');
    }
    public function daftar_login_4get()
    {
        return $this->hasOne(DaftarLogin_Model::class, 'id_client');

    }

    ///// REMOVED
    // public function absen()
    // {
    //     return $this->hasMany(Absen_Model::class, 'id_client');
    // }



}
