@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Task: <strong>{{$task->title}}</strong></h4>
                    <h6>Project: <a href="{{route('admin.project.show', [encrypt($task->project->id)])}}" class="link-stabilize"><strong>{{$task->project->title}}</strong></a></h6>
                 </div>

                <div class="card-body">
                    <strong>Title: </strong>{{$task->title}} <br>
                    <strong>Description: </strong>{{$task->description}} <br>
                    <strong>Point: </strong>{{$task->point}} <br>
                    <strong>Ended: </strong>{{$task->deadline}} <br>

                    <hr>

                    @if(count($taskEmployees) == 0)
                        No Employee Available
                    @else
                        <strong>Employees:</strong>
                        <br>
                        {{$taskEmployees->links()}}   
                        <table width="100%">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                            @foreach($taskEmployees as $employee)
                                <tr>
                                    <td>{{$employee->name}}</td>
                                    <td>{{$employee->email}}</td>
                                    <td>{{$employee->pivot->status}}</td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
