<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DaftarTask_Model;

class tb_TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // start_time_task, descb_task,                      progress_current_task, id_ws, id_projects, id_monitoring
        $taskList = [
            // // [now()->subDay(),        "AAA",               null,     1,  'PRJ-24-0001', 1],
            // // [now()->subDay(),        "BBB",               null,     1,  'PRJ-24-0001', 2],
            // // [now()->subDay(),        "CCC",               null,     1,  'PRJ-24-0001', 3],
            // // [now(),                  "DDD",               null,     4,  'PRJ-24-0001', 2],
            // // [now(),                  "EEE",               null,     4,  'PRJ-24-0001', 2],
            // // [now()->addDay(),        "GGG",               null,     6,  'PRJ-24-0001', 3],
            // ['14:40:37', '- AAAAAAAA\n- AAAAAAAA\n- AAAAAAAA', 12, 1, 'PRJ-24-0001', 1],
            // ['15:00:00', '- BBBBBBB\n- BBBBBBB\n- BBBBBBB', 4, 1, 'PRJ-24-0001', 1],
            // ['16:00:00', '- CCCCCCC\n- CCCCCCC\n- CCCCCCC', 8, 1, 'PRJ-24-0001', 1],
            // // ['17:00:00', '- DDDDDDD\n- DDDDDDD\n- DDDDDDD', 12, 1, 'PRJ-24-0001', 1],
            // // ['18:00:00', '- EEEEEEE\n- EEEEEEE\n- EEEEEEE', 16, 1, 'PRJ-24-0001', 1],
            // // ['19:00:00', '- FFFFFFF\n- FFFFFFF\n- FFFFFFF', 20, 1, 'PRJ-24-0001', 1],
            // // ['20:00:00', '- GGGGGGG\n- GGGGGGG\n- GGGGGGG', 24, 1, 'PRJ-24-0001', 1],
            // // ['21:00:00', '- HHHHHHH\n- HHHHHHH\n- HHHHHHH', 28, 1, 'PRJ-24-0001', 1],
            // // ['22:00:00', '- IIIIIII\n- IIIIIII\n- IIIIIII', 32, 1, 'PRJ-24-0001', 1],
            // // ['23:00:00', '- JJJJJJJ\n- JJJJJJJ\n- JJJJJJJ', 36, 1, 'PRJ-24-0001', 1],
            // // ['00:00:00', '- KKKKKKK\n- KKKKKKK\n- KKKKKKK', 40, 1, 'PRJ-24-0001', 1],
            // // ['01:00:00', '- LLLLLLL\n- LLLLLLL\n- LLLLLLL', 44, 1, 'PRJ-24-0001', 1],
            // // ['02:00:00', '- MMMMMMM\n- MMMMMMM\n- MMMMMMM', 48, 1, 'PRJ-24-0001', 1],
            // // ['03:00:00', '- NNNNNNN\n- NNNNNNN\n- NNNNNNN', 52, 1, 'PRJ-24-0001', 1],
            // // ['04:00:00', '- OOOOOOO\n- OOOOOOO\n- OOOOOOO', 56, 1, 'PRJ-24-0001', 1],
            // // ['05:00:00', '- PPPPPPP\n- PPPPPPP\n- PPPPPPP', 60, 1, 'PRJ-24-0001', 1],
            // // ['06:00:00', '- QQQQQQQ\n- QQQQQQQ\n- QQQQQQQ', 64, 1, 'PRJ-24-0001', 1],
            // // ['07:00:00', '- RRRRRRR\n- RRRRRRR\n- RRRRRRR', 68, 1, 'PRJ-24-0001', 1],
            // // ['08:00:00', '- SSSSSSS\n- SSSSSSS\n- SSSSSSS', 72, 1, 'PRJ-24-0001', 1],

        ];
        foreach ($taskList as $task) {
            $model = new DaftarTask_Model();
            $model->start_time_task = $task[0];
            $model->descb_task = $task[1];
            // $model->progress_actual_task = $task[2];
            $model->progress_current_task = $task[2];
            $model->id_ws = $task[3];
            $model->id_project = $task[4];
            $model->id_monitoring = $task[5];
            $model->save();
        }
    }
}
