<?php


namespace App\Http\Controllers\User;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\User\TaskService;


class TaskController extends Controller
{

    private $taskService;

    public function __construct(TaskService $taskService)
    {
        try {
            $this->middleware('user');
            $this->taskService = $taskService;
        }
        catch(\Exception $error){
            return back()->with('error', ':( Something Went Wrong!');
        }

    }

    public function index()
    {
        try {
            $data['assignedTasks'] = $this->taskService->usersAssignedTasks();
            return view('user.task.index',$data);
        }
        catch(\Exception $error){
            return back()->with('error', ':( Something Went Wrong!');
        }


    }

    public function show($encryptedId){

        try {
            $data['taskDetails'] = $this->taskService->taskDetails($encryptedId);
            $data['statusInfo'] = $this->taskService->statusInfo($encryptedId);
            return view('user.task.showTasks',$data);
        }
        catch(\Exception $error){
            return back()->with('error', ':( Something Went Wrong!');
        }


    }
    public function update($encryptedId){
        try {
            $this->taskService->updateUserRecords($encryptedId);
            $this->taskService->updateStatus($encryptedId);

            return redirect (route('user.task.index'));
        }
        catch(\Exception $error){
            return back()->with('error', ':( Something Went Wrong!');
        }

    }

    public function showRecords(){
        try {
            $data['completedTasks'] = $this->taskService->userCompletedTasks();
            $data['userDetails'] = $this->taskService->userDetails();
            return view('user.showRecords',$data);

        }
        catch(\Exception $error){
            return back()->with('error', ':( Something Went Wrong!');
        }
    }
}
