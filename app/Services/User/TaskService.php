<?php

namespace App\Services\User;

use App\Models\Project;
use App\Models\Record;
use App\Models\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskService{

    public function usersAssignedTasks(){
        $date = Carbon::now()->format('Y-m-d');
        $user = User::find(Auth::user()->id);
        return $user->tasks()->where('deadline','>=', $date)->get();
    }

    public function taskDetails($encryptedId){

        $id = decrypt($encryptedId);
        return Task::where('id', $id)->get();
    }

    public function statusInfo($encryptedId){

        $id = decrypt($encryptedId);
        return Auth::user()->tasks()->where('task_id', $id)->first();
    }

    public function updateStatus($encryptedId){

        $id = decrypt($encryptedId);
        $task = Auth::user()->tasks()->where('task_id', $id)->first();

        if($task->pivot->status == 'Not Started'){
                $task->pivot->update([
                'status'=>'Running'

            ]);
        }
        elseif ($task->pivot->status == 'Running'){
                $task->pivot->update([
                'status'=>'Completed'

            ]);
        }
    }

    public function updateUserRecords($encryptedId){

        $id = decrypt($encryptedId);
        $userRecord = Record::where('user_id', Auth::user()->id)->first();
        $completeChecker = Auth::user()->tasks()->where('task_id', $id)->first()->pivot->status;
        $taskPoint = Task::where('id', $id)->first()->point;

        if ($completeChecker == 'Completed'){

            $userRecord->update([
                'task_due'=>$userRecord->task_due - 1,
                'task_done'=>$userRecord->task_done + 1,
                'point_due'=>$userRecord->point_due - $taskPoint,
                'earned_point'=>$userRecord->earned_point + $taskPoint,
            ]);
        }

    }

    public function userDetails(){

        $id = Auth::user()->id;
        return Record::where('user_id',$id)->first();

    }

    public function userCompletedTasks(){

        $user = User::find(Auth::user()->id);
        $completeCheckers = $user->tasks()->get();
        $taskIds = [];

        foreach ($completeCheckers as $completeChecker){

            if ($completeChecker->pivot->status == 'Completed'){

                array_push($taskIds,$completeChecker->pivot->task_id);
            }
        }
        return Task::whereIn('id', $taskIds)->get();

    }



}
