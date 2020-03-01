<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Requests\TaskRequest;
use App\Mail\WelcomeMemberMail;
use App\Project;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller
{
    public function createProject(){

        return view('layouts.createProject');
    }

    public function storeProject(ProjectRequest $request){

        $validated = $request->validated();
        try {
            DB::beginTransaction();
            Project::create($validated);
            DB::commit();
            return back()->with('messages', 'Project saved successfully!');
        }
        catch (\Exception $errors){
            //dd($errors);
            DB::rollBack();
            return redirect()->back()->with('messages', __('Something went wrong'));
        }

    }

    public function createTask(){

        $data['projects'] =Project::all();
        return view('layouts.createTask',$data);
    }

    public function storeTask(TaskRequest $request){

        $validated = $request->validated();
        try {
            DB::beginTransaction();
            Task::create($validated);
            DB::commit();
            return back()->with('messages', 'Task saved successfully!');
        }
        catch (\Exception $errors){
            //dd($errors);
            DB::rollBack();
            return redirect()->back()->with('messages', __('Something went wrong'));
        }
    }


    public function addUser(){

        $data['tasks'] = Task::all();
        $data['users'] = User::all();
        return view('layouts.addUser',$data);
    }

    public function storeUser(Request $request){

        try{
            DB::beginTransaction();
            User::where('id',$request->user_id)->update(['task_id' => $request->task_id]);
            //$task->users()->syncWithoutDetaching($request->user_id);
            DB::commit();
            $email = User::where('id',$request->user_id)->value('email');
            Mail::to($email)->send(new WelcomeMemberMail);

        }
        catch (\Exception $errors){
            dd($errors);
            DB::rollBack();
            return redirect()->back()->with('messages', __('Something went wrong'));
        }


    }

    public function searchUsersForassignedTasks(Request $request){

        $data['projects'] = Project::all();
        $data['tasks'] = Task::where('project_id',$request->project_id)->get();
        $data['searchedProjects'] = Project::where('id',$request->project_id)->get();
        $data['users'] = User::where('task_id',$request->task_id)->get();
        $data['searchedTasks'] = Task::where('id',$request->task_id)->get();
        return view('welcome',$data);

    }
}
