@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Task: <strong>{{$task->title}}</strong></h4>
                    <h6>Project: <a href="{{route('admin.project.show', [encrypt($task->project->id)])}}" class="link-stabilize"><strong>{{$task->project->title}}</strong></a></h6>
                 </div>

                <div class="card-body col-md-12">
                    <div class="row">
                        <div class="card col-md-8 pt-3 pb-3">
                            <ul class="nav">
                                <li class="nav-item mr-2">
                                    <a class="nav-link btn btn-secondary" href="{{route('admin.project.task.edit', [encrypt($task->id)])}}">Edit</a>
                                </li>
                                {{--  <form action="" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="nav-link btn btn-secondary">Delete</button>
                                </form>  --}}
                            </ul>

                            <hr>

                            <div id="task-info" class="col-md-12">
                                <strong>Title: </strong>{{$task->title}} <br>
                                <strong>Description: </strong>{{$task->description}} <br>
                                <strong>Point: </strong>{{$task->point}} <br>
                                <strong>Deadline: </strong>{{$task->deadline}} <br>

                                <hr>

                                @if(count($taskEmployees) == 0)
                                    No Employee Available
                                @else
                                    <strong>Employees:</strong>
                                    <br><br>
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
                        <div id="not-employee" class="card col-md-4 pt-3 pb-3">
                            <div >
                                <h5><strong>Add Employee to Task</strong></h5>
                                <hr>
                                {{$notTaskEmployees->links()}}
                                <form id="message" action="{{route('admin.project.task.employee.add', [encrypt($task->id)])}}" method="post">
                                    @csrf
                                    @foreach($notTaskEmployees as $employee)
                                        <input type="checkbox" name="employee{{$employee->id}}" id="" value="{{$employee->id}}"> {{$employee->name}} <br>
                                    @endforeach
                                    <br>
                                    <button  type="submit" class="btn btn-primary">Add</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="script">
    <script>
        $(document).ready(function(){
            $("#send").on("click", function() {
                $.ajax({
                    type: "post",
                    url: "",
                    data: $("#message").serialize(),
                    success: function(response) {
                        $("#task-info").html($(response).find('#task-info').html());
                        $("#not-employee").html($(response).find('#not-employee').html());
                        $("#script").html($(response).find('#script').html());
                    },
                    error: function() {
                        alert("Something went wrong!");
                    }
                });
            });
        });

    </script>
</div>
@endsection
