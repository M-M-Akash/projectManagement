<?php

namespace App\Http\Controllers\Admin;

use App\Project;
use Illuminate\Http\Request;
use App\Services\Admin\TaskService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Services\Admin\ProjectService;

class ProjectController extends Controller
{
    private $projectService;
    private $taskService;

    public function __construct(ProjectService $projectService, TaskService $taskService)
    {
        $this->middleware('admin');
        $this->projectService = $projectService;
        $this->taskService = $taskService;
    }

    public function index()
    {
        $runningProjects = $this->projectService->getAuthUserRunningProjects();
        $expiredProjects = $this->projectService->getAuthUserExpiredProjects();
        return view('admin.project.index',compact('runningProjects', 'expiredProjects'));
    }

    public function create()
    {
        return view('admin.project.create');
    }

    public function store(ProjectRequest $request)
    {
        try{
            $this->projectService->createNewProject($request);
        }catch(\Exception $error){
            return back()->with('error', ':( Something Went Wrong!');
        }
        return redirect(route('admin.project.index'))->with('success', 'Project has been created successfully');
    }

    public function show($encryptedId)
    {
        try{
            $project = $this->projectService->decryptAndFindProject($encryptedId);
            $expired = $this->projectService->checkExpired($project);
            if($expired == true){
                $tasks = $project->tasks;
                return view('admin.project.show_expired',compact('project', 'tasks'));
            }else{
                $runningTasks = $this->taskService->getRunningTasks($project);
                $expiredTasks = $this->taskService->getExpiredTasks($project);
                return view('admin.project.show',compact('project', 'runningTasks', 'expiredTasks'));
            }
        }catch(\Exception $error){
            return back()->with('error', ':( Something Went Wrong!');
        }
    }

    public function edit($encryptedId)
    {
        try{
            $project = $this->projectService->decryptAndFindProject($encryptedId);
        }catch(\Exception $error){
            return back()->with('error', ':( Something Went Wrong!');
        }
        return view('admin.project.edit',compact('project'));
    }

    public function update($encryptedId, ProjectRequest $request)
    {
        try{
            $project = $this->projectService->decryptAndFindProject($encryptedId);
            $this->projectService->updateProject($project, $request);
        }catch(\Exception $error){
            return back()->with('error', ':( Something Went Wrong!');
        }
        return redirect(route('admin.project.show',[encrypt($project->id)]));
    }
}
