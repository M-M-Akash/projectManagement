<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Services\Admin\TaskService;
use App\Http\Controllers\Controller;
use App\Services\Admin\ProjectService;

class TaskController extends Controller
{
    private $projectService;
    private $taskService;

    public function __construct(ProjectService $projectService, TaskService $taskService)
    {
        $this->middleware('admin');
        $this->projectService = $projectService;
        $this->taskService = $taskService;
    }

    public function create($encryptedProjectId)
    {
        try{
            $project = $this->projectService->decryptAndFindProject($encryptedProjectId);
            $taskMaxPoint = (1000-$project->total_point > 100) ? 100 : 1000-$project->total_point;
        }catch(\Exception $error){
            return back()->with('error', ':( Something Went Wrong!');
        }
        return view('admin.task.create', compact('project', 'taskMaxPoint'));
    }

    public function store($encryptedProjectId, TaskRequest $request)
    {
        try{
            $project = $this->projectService->decryptAndFindProject($encryptedProjectId);
            $this->taskService->createNewTask($project, $request);
        }catch(\Exception $error){
            return back()->with('error', ':( Task cannot be saved. Try again!');
        }
        return redirect(route('admin.project.show', [encrypt($project->id)]));
    }

    public function show($encryptedId)
    {
        try{
            $task = $this->taskService->decryptAndFindTask($encryptedId);
            $taskEmployees = $task->users()->paginate(5);
            $expired = $this->taskService->checkExpired($task);
            if($expired == true){
                return view('admin.task.show_expired',compact('task', 'taskEmployees'));
            }else{
                $notTaskEmployees = $this->taskService->getEmployeesExceptThisTask($task);
                return view('admin.task.show',compact('task', 'taskEmployees', 'notTaskEmployees'));
            }

        }catch(\Exception $error){
            return back()->with('error', ':( Something Went Wrong!');
        }
    }

    public function edit($encryptedId)
    {
        try{
            $task = $this->taskService->decryptAndFindTask($encryptedId);
            $taskMaxPoint = (1000 - $task->project->total_point + $task->point > 1000) ? 100 : 1000 - $task->project->total_point + $task->point;
        }catch(\Exception $error){
            return back()->with('error', ':( Something Went Wrong!');
        }
        return view('admin.task.edit',compact('task', 'taskMaxPoint'));
    }

    public function update($encryptedId, TaskRequest $request)
    {
        try{
            $task = $this->taskService->decryptAndFindTask($encryptedId);
            $this->taskService->updateTask($task, $request);
        }catch(\Exception $error){
            return back()->with('error', ':( Something Went Wrong!');
        }
        return redirect(route('admin.project.task.show',[encrypt($task->id)]));
    }

    public function addEmployee($encryptedId, Request $request)
    {
        try{
            $task = $this->taskService->decryptAndFindTask($encryptedId);
            $this->taskService->addEmployeeToTask($task, $request);
        }catch(\Exception $error){
            return back()->with('error', ':( Something Went Wrong!');
        }
        return back()->with('success', 'Member Added');
    }
}
