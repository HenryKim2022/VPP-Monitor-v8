<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Team_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_team';
    protected $primaryKey = 'id_team';

    protected $fillable = [
        'id_team', 'na_team'
    ];

    protected $dates = ['deleted_at'];


    public function karyawans()
    {
        return $this->hasMany(Karyawan_Model::class, 'id_team', 'id_team');
    }
    // public function projects()
    // {
    //     return $this->hasMany(Projects_Model::class, 'id_project', 'id_project');
    // }

}
