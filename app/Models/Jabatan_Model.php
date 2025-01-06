<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Jabatan_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_jabatan'; // Replace with the actual table name
    protected $primaryKey = 'id_jabatan';

    protected $fillable = [
        'na_jabatan', 'id_karyawan'
    ];

    protected $dates = ['deleted_at']; // Specify the column for soft deletes


    public function karyawan()
    {
        return $this->belongsTo(Karyawan_Model::class, 'id_karyawan');
    }
}
