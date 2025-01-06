<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;


class DaftarWS_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_worksheet';
    protected $primaryKey = 'id_ws';
    protected $fillable = ['working_date_ws', 'arrival_time_ws', 'finish_time_ws', 'status_ws', 'expired_at_ws', 'closed_at_ws', 'remark_ws', 'id_karyawan', 'id_project'];


    public function working_date_ws()
    {
        if (isset($this->attributes['working_date_ws']) && !empty($this->attributes['working_date_ws'])) {
            try {
                Carbon::setLocale('id'); // Set locale to Indonesian
                return Carbon::parse($this->attributes['working_date_ws'])->locale('id')->translatedFormat('d M Y');
            } catch (\Exception $e) {
                return 'Stored date format isn\'t valid!';
            }
        }
        return null;
    }


    // public function checkAllWSStatus()
    // {
    //     $statuses = $this->whereNotNull('status_ws')->where('status_ws', '<>', 'softdeleted')->pluck('status_ws')->toArray();
    //     if (in_array('OPEN', $statuses)) {
    //         return 'OPEN';
    //     }
    //     return 'CLOSED'; // Return 'CLOSED' if no 'OPEN' status found
    // }

    public function checkAllWSStatus()
    {
        // Use the project relationship to get the project ID
        $projectId = $this->project->id_project;

        $statuses = $this->whereNotNull('status_ws')
            ->where('status_ws', '<>', 'softdeleted')
            ->where('id_project', $projectId) // Filter by the project's ID from the relationship
            ->pluck('status_ws')
            ->toArray();

        if (in_array('OPEN', $statuses)) {
            return 'OPEN';
        }
        return 'CLOSED'; // Return 'CLOSED' if no 'OPEN' status found
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan_Model::class, 'id_karyawan');
    }

    public function project()
    {
        return $this->belongsTo(Projects_Model::class, 'id_project', 'id_project');
    }

    public function getClientData()
    {
        // Check if the project relationship is loaded
        if ($this->relationLoaded('project')) {
            $client = $this->project->client;
            return $client;
        }
        return null;
    }

    public function task()
    {
        return $this->hasMany(DaftarTask_Model::class, 'id_ws', 'id_ws');
    }


    // public function monitoring()
    // {
    //     return $this->belongsTo(Monitoring_Model::class, 'id_monitoring', 'id_monitoring');
    // }


    // // public function monitoring()
    // // {
    // //     return $this->hasMany(Monitoring_Model::class, 'id_project', 'id_project');
    // // }


    public function monitoring()
    {
        return $this->hasMany(Monitoring_Model::class, 'id_monitoring', 'id_monitoring')
            ->join('tb_task', 'tb_task.id_task', '=', 'tb_monitoring.id_task')
            ->whereNull('tb_monitoring.deleted_at')
            ->whereNull('tb_task.deleted_at');
    }


    public function executedby()
    {
        return $this->belongsTo(Karyawan_Model::class, 'id_karyawan');
    }
}
