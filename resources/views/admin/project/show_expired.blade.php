@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h4>Project: <strong>{{$project->title}}</strong></h4></div>

                <div class="card-body">
                    <div class="col-md-12">
                        <strong>Title: </strong>{{$project->title}} <br>                      
                        <strong>Description: </strong>{{$project->description}} <br>  
                        <strong>Total Point: </strong>{{$project->total_point}} <br>  
                        <strong>Deadline: </strong>{{$project->deadline}} <br>  

                        <hr>
                        @if(count($tasks) == 0)
                            No Task Available
                        @else
                            <strong>Tasks:</strong>
                            <table width="100%">
                                <tr>
                                    <th>Title</th>
                                    <th>Total Point</th>
                                    <th>Deadline</th>
                                </tr>
                                @foreach($tasks as $task)
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
            </div>
        </div>
    </div>
</div>
@endsection
