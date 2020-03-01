<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\User;
use App\Models\Record;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public function getRunningTasks($project)
    {
        $date = Carbon::now()->format('Y-m-d');
        return Task::where('deadline','>=', $date)
                    ->where('project_id', $project->id)
                    ->paginate(5);
    }

    public function getExpiredTasks($project)
    {
        $date = Carbon::now()->format('Y-m-d');
        return Task::where('deadline','<', $date)
                    ->where('project_id', $project->id)
                    ->paginate(5);
    }

    public function decryptAndFindTask($encryptedId)
    {
        $id = decrypt($encryptedId);
        return Task::find($id);
    }

    public function checkExpired($task){
        $date = Carbon::now()->format('Y-m-d');
        $task = Task::where('id', $task->id)
                ->where('deadline','>=', $date)
                ->first();
        if($task == null){
            return true;
        }else{
            return false;
        }
    }

    public function createNewTask($project, $request)
    {
        if($project->total_point + $request->point > 1000){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'message' => 'Project Point getting larger than allowed',
            ]);
            throw $error;
        }else{
            try{
                DB::beginTransaction();
                $task = Task::create([
                    'project_id' => $project->id,
                    'title'=>$request->title,
                    'description'=>$request->description,
                    'point'=>$request->point,
                    'deadline'=>$request->deadline,
                ]);
                $project->update([
                    'total_point' => $project->total_point + $task->point,
                ]);
                DB::commit();
            }catch(\Exception $error){
                DB::rollback();
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'message' => 'Task cannot be saved.',
                ]);
                throw $error;
            }
        }

    }

    public function updateTask($task, $request)
    {
        $task->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'point'=>$request->point,
            'deadline'=>$request->deadline,
        ]);
    }

    public function getEmployeesExceptThisTask($task)
    {
        $users = $task->users;
        $employeeId = [];
        foreach($users as $user){
            $employeeId[] += $user->id;
        }
        $employeeId[] += $task->project->user_id;
        return User::whereNotIn('id', $employeeId)->paginate(15);
    }

    public function addEmployeeToTask($task, $request)
    {
        $parameters = $request->request;
        //$userIds = [];
        foreach($parameters as $key => $employeeId){
            if($key!="_token"){
                try{
                    DB::beginTransaction();
                        $task->users()->attach($employeeId, ['status' => 'Not Started']);
                        $record = Record::where('user_id', $employeeId)->first();
                        if($record != null){
                            $record->update([
                                'task_due' => $record->task_due + 1,
                                'point_due' => $record->point_due + $task->point,
                            ]);
                        }else{
                            Record::create([
                                'user_id' => $employeeId,
                                'task_done' => 0,
                                'earned_point' => 0,
                                'task_due' => 1,
                                'point_due' => $task->point,
                            ]);
                        }
                    DB::commit();
                }catch(\Exception $error){
                    DB::rollback();
                }
            }
        }
    }
}
