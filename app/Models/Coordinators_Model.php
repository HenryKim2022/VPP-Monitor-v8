<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coordinators_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_cos';
    protected $primaryKey = 'id_co';

    protected $fillable = [
        'id_project',
        'id_karyawan'
    ];

    protected $dates = ['deleted_at'];

    public function project()
    {
        return $this->belongsTo(Projects_Model::class, 'id_project', 'id_project');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan_Model::class, 'id_karyawan','id_karyawan');
    }


}
