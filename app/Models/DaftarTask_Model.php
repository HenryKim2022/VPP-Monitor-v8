<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DaftarTask_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_task';
    protected $primaryKey = 'id_task';
    protected $fillable = ['start_time_task', 'descb_task', 'progress_current_task', 'id_ws', 'id_project', 'id_monitoring'];


    public function worksheet()
    {
        return $this->belongsTo(DaftarWS_Model::class, 'id_ws');
    }

    public function project()
    {
        return $this->belongsTo(Projects_Model::class, 'id_project');
    }


    // public function category()
    // {
    //     return $this->belongsTo(Monitoring_Model::class, 'id_project');
    // }


    public function monitor()
    {
        return $this->belongsTo(Monitoring_Model::class, 'id_monitoring', 'id_monitoring');
    }


    // // // public function last_task_progress_update($id_monitoring)
    // // // {
    // // //     return $this->where('id_monitoring', $id_monitoring)
    // // //         ->orderBy('updated_at', 'desc')
    // // //         ->value('progress_current_task');
    // // // }


    // // public function last_task_progress_update($id_monitoring)
    // // {
    // //     return $this->where('id_monitoring', $id_monitoring)
    // //         ->whereNull('deleted_at')
    // //         ->sum('progress_current_task');
    // // }

    // public function last_task_progress_update($id_monitoring)
    // {
    //     return $this->where('id_monitoring', $id_monitoring)
    //         ->whereNull('deleted_at') // Exclude soft-deleted records
    //         ->whereHas('worksheet', function ($query) {
    //             $query->whereNull('expired_at_ws'); // Check if expired_at_ws is null
    //         })
    //         ->sum('progress_current_task');
    // }

    public function rel_monitor_task_total()    // THIS IS IMPORTANT!!! MONDWS UPDATE PROGRESS COLUMN OLD VERSION AT PRINT MONITORING
    {
        return $this->where('id_monitoring', $this->id_monitoring)
            ->whereNull('deleted_at') // Exclude soft-deleted records
            ->whereHas('worksheet', function ($query) {
                $query->whereNull('expired_at_ws') // Check if expired_at_ws is null
                    ->where('status_ws', 'CLOSED'); // Check if status_ws is 'CLOSED'
            })
            ->orderBy('updated_at', 'desc')
            ->value('progress_current_task');
    }

    public function last_task_progress_update($id_monitoring)   // THIS IS IMPORTANT!!! ACT DISABLER/ENABLER MONDWS
    {
        return $this->where('id_monitoring', $id_monitoring)
            ->whereNull('deleted_at') // Exclude soft-deleted records
            ->whereHas('worksheet', function ($query) {
                $query->whereNull('expired_at_ws') // Check if expired_at_ws is null
                    ->where('status_ws', 'CLOSED'); // Check if status_ws is 'CLOSED'
            })
            ->sum('progress_current_task');
    }


    public function isRelatedTaskEmpty($id_ws, $id_project)  // THIS IS IMPORTANT!!! WORKSHEET DELETING PART
    {
        return $this->where('id_ws', $id_ws)
            ->where('id_project', $id_project)
            ->whereNull('deleted_at') // Exclude soft-deleted records
            ->exists(); // Check if any record exists
    }


    public function sumProgressByMonitoring($id_monitoring) // THIS IS IMPORTANT!!! MONITORING TBODY PART
    {
        return $this->where('id_monitoring', $id_monitoring)
            ->whereNull('deleted_at') // Exclude soft-deleted records
            ->whereHas('worksheet', function ($query) {
                $query->whereNull('expired_at_ws') // Check if expired_at_ws is null
                    ->where('status_ws', 'CLOSED'); // Check if status_ws is 'CLOSED'
            })
            ->sum('progress_current_task');
    }

    public function sumProgressByMonitoringUnsaved($id_monitoring) // THIS IS IMPORTANT!!! MONITORING TBODY PART
    {
        return $this->where('id_monitoring', $id_monitoring)
            ->whereNull('deleted_at') // Exclude soft-deleted records
            ->whereHas('worksheet', function ($query) {
                $query->where('status_ws', 'OPEN') // Check if status_ws is 'CLOSED'
                    ->whereNotNull('expired_at_ws');
            })
            ->sum('progress_current_task');
    }
}
