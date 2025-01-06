<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projects_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_projects'; // Replace with the actual table name
    protected $primaryKey = 'id_project';
    public $incrementing = false;   // Manually input id_project tr input field

    protected $fillable = [
        'id_project',
        'na_project',
        'start_project',
        'deadline_project',
        'status_project',
        'closed_at_project',
        'show_to_client',
        'id_client',
        'order'
        // 'id_karyawan',
        // 'id_team'
    ];

    protected $dates = ['deleted_at']; // Specify the column for soft deletes



    public function isShowToClient()
    {
        // Assuming show_to_client can be 0 (No) or 1 (Yes)
        return (bool) $this->show_to_client; // Cast to boolean
    }



    public function client()
    {
        return $this->belongsTo(Kustomer_Model::class, 'id_client');
    }
    // public function pcoordinator()
    // {
    //     return $this->belongsTo(Karyawan_Model::class, 'id_karyawan');
    // }
    // public function team()
    // {
    //     return $this->belongsTo(Team_Model::class, 'id_team');
    // }
    // public function karyawan()
    // {
    //     return $this->belongsTo(Karyawan_Model::class, 'id_karyawan');
    // }

    public function coordinators()
    {
        return $this->hasMany(Coordinators_Model::class, 'id_project', 'id_project');
    }

    public function prjteams()
    {
        return $this->hasMany(Projects_Teams_Model::class, 'id_project', 'id_project');
    }


    // Define many-to-many relationship with Coordinators
    public function savecoordinators()
    {
        return $this->belongsToMany(Coordinators_Model::class, 'coordinator_project', 'id_project', 'id_coordinator');
    }

    // Define many-to-many relationship with Teams
    public function saveteams()
    {
        return $this->belongsToMany(Team_Model::class, 'team_project', 'id_project', 'id_team');
    }



    public function monitor()
    {
        return $this->hasMany(Monitoring_Model::class, 'id_project');
    }


    public function prjstatus_beta()
    {
        $total = 0;
        $totalActual = 0;
        if ($this->monitor->isNotEmpty()) {
            foreach ($this->monitor as $monitor) {
                foreach ($this->monitor as $monitor) {
                    if ($monitor->qty && $monitor->task) {
                        $qty = $monitor->qty;
                        $up = $monitor->task->last_task_progress_update(
                            $monitor->id_monitoring,
                        );
                        $total = ($qty * $up) / 100;
                        $totalActual += $total;
                    }
                }
            }
        }
        return $totalActual >= 100 ? 'FINISH' : 'ONGOING';
    }

    public function prj_progress_totals()
    {
        $totalActual = 0;
        if ($this->monitor->isNotEmpty()) {
            foreach ($this->monitor as $monitor) {
                if ($monitor->qty) {
                    foreach ($monitor->tasks as $task) {
                        $up = $task->last_task_progress_update($monitor->id_monitoring);
                        $total = ($monitor->qty * $up) / 100;
                        $totalActual += $total;
                    }
                }
            }
        }

        return $totalActual;
    }

    // public function prj_progress_totals_unlockedtask()
    // {
    //     $totalActual = 0;
    //     if ($this->monitor->isNotEmpty()) {
    //         foreach ($this->monitor as $monitor) {
    //             if ($monitor->qty) {
    //                 foreach ($monitor->tasks as $task) {
    //                     $up = $task->unlocked_last_task_progress_update($monitor->id_monitoring);
    //                     $total = ($monitor->qty * $up) / 100;
    //                     $totalActual += $total;
    //                 }
    //             }
    //         }
    //     }

    //     return $totalActual;
    // }



    public function task()
    {
        return $this->hasMany(DaftarTask_Model::class, 'id_project');
    }




    public function worksheet()
    {
        return $this->hasMany(DaftarWS_Model::class, 'id_project');
    }
}
