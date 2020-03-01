@extends('layouts.user')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h4>User</h4></div>

                    <div class="card-body">

                        <table width="100%">
                        <tr>
                            <th>title</th>
                            <th>point</th>
                            <th>deadline</th>
                            <th>Status</th>
                        </tr>
                            @foreach($assignedTasks as $assignedTask)
                            <tr>
                                <td><a href="{{route('user.task.show',[encrypt($assignedTask->id)])}}" class="link-stabilize">{{$assignedTask->title}}</a></td>
                                <td>{{$assignedTask->point}}</td>
                                <td>{{$assignedTask->deadline}}</td>
                                <td>{{$assignedTask->pivot->status}}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
