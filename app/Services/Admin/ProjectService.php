<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use Carbon\Carbon;

class ProjectService
{
    public function getAuthUserRunningProjects()
    {
        $date = Carbon::now()->format('Y-m-d');
        return Auth::user()->projects()->where('deadline','>=', $date)->paginate(5);
    }
    public function getAuthUserExpiredProjects()
    {
        $date = Carbon::now()->format('Y-m-d');
        return Auth::user()->projects()->where('deadline','<', $date)->paginate(5);
    }

    public function decryptAndFindProject($encryptedId)
    {
        $id = decrypt($encryptedId);
        return Project::find($id);
    }

    public function checkExpired($project){
        $date = Carbon::now()->format('Y-m-d');
        $project = Project::where('id', $project->id)
                ->where('deadline','>=', $date)
                ->first();
        if($project == null){
            return true;
        }else{
            return false;
        }
    }

    public function createNewProject($request)
    {
        Project::create([
            'user_id' => Auth::user()->id,
            'title'=>$request->title,
            'description'=>$request->description,
            'total_point'=>0,
            'deadline'=>$request->deadline,
        ]);
    }

    public function updateProject($project, $request)
    {
        $project->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'deadline'=>$request->deadline,
        ]);
    }
}
