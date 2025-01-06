<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Monitoring_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_monitoring';
    protected $primaryKey = 'id_monitoring';
    // protected $fillable = ['category', 'achieve_date','qty','id_ws','id_karyawan','id_project'];
    protected $fillable = ['category', 'start_date', 'end_date', 'achieve_date', 'qty', 'id_karyawan', 'id_project', 'order'];



    // public function worksheet()
    // {
    //     return $this->hasMany(DaftarWS_Model::class, 'id_ws');
    // }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan_Model::class, 'id_karyawan', 'id_karyawan');
    }

    public function project()
    {
        return $this->belongsTo(Projects_Model::class, 'id_project', 'id_project');
    }

    // public function task()
    // {
    //     return $this->belongsTo(DaftarTask_Model::class, 'id_project', 'id_project');
    // }

    public function tasks()
    {
        return $this->hasMany(DaftarTask_Model::class, 'id_monitoring', 'id_monitoring');
    }


}
