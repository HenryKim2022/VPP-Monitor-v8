<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Projects_Teams_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_projects_teams';
    protected $primaryKey = 'id_prj_team';

    protected $fillable = [
        'id_team', 'id_project'
    ];

    protected $dates = ['deleted_at'];


    public function team()
    {
        return $this->belongsTo(Team_Model::class, 'id_team', 'id_team');
    }
    public function projects()
    {
        return $this->hasMany(Projects_Model::class, 'id_project', 'id_project');
    }

}
