@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h4>Project: <strong>{{$project->title}}</strong></h4></div>

                <div class="card-body col-md-12">
                    <div class="row">
                        <div class="card col-md-8 pt-3 pb-3">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link btn btn-secondary" href="{{route('admin.project.edit', [encrypt($project->id)])}}">Edit</a>
                                </li>
                                {{--  <form action="" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="nav-link btn btn-secondary">Delete</button>
                                </form>  --}}
                                <li class="nav-item ml-2">
                                    <a class="nav-link btn btn-secondary" href="{{route('admin.project.task.create',[encrypt($project->id)])}}">Add Task</a>
                                </li>
                            </ul>

                            <hr>
                            
                            <div class="col-md-12">
                                <strong>Title: </strong>{{$project->title}}<br>
                                <strong>Description: </strong>{{$project->description}}<br>
                                <strong>Total Point: </strong>{{$project->total_point}}<br>
                                <strong>Deadline: </strong>{{$project->deadline}}<br>

                                <hr>
                                @if(count($runningTasks) == 0)
                                    No Task Available
                                @else
                                    <strong>Tasks:</strong>
                                    <table width="100%">
                                        <tr>
                                            <th>Title</th>
                                            <th>Total Point</th>
                                            <th>Deadline</th>
                                        </tr>
                                        @foreach($runningTasks as $task)
                                            <tr>
                                                <td>
                                                    <a href="{{route('admin.project.task.show', [encrypt($task->id)])}}" class="link-stabilize">{{$task->title}}</a>  
                                                </td>
                                                <td>{{$task->point}}</td>
                                                <td>{{$task->deadline}}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif
                            </div>
                        </div>
                        <div class="card col-md-4 pt-3 pb-3">                            
                            @if(count($expiredTasks) == 0)
                                No Expired Task
                            @else
                                <h5><strong>Expired Tasks</strong></h5>
                                <hr>

                                <table width="100%">
                                    <tr>
                                        <th>Title</th>
                                        <th>Total Point</th>
                                    </tr>
                                    @foreach($expiredTasks as $task)
                                        <tr>
                                            <td>
                                                <a href="{{route('admin.project.task.show', [encrypt($task->id)])}}" class="link-stabilize">{{$task->title}}</a>  
                                            </td>
                                            <td>{{$task->point}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
