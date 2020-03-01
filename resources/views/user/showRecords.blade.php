@extends('layouts.user')

@section('content')
    <div class="card col-md-4 pt-3 pb-3">
        @if ($userDetails == 0)
            No Task is appointed yet<br>
        @else
            <strong>Tasks Done: </strong>{{$userDetails->task_done}}<br>
            <strong>Tasks Due: </strong>{{$userDetails->task_due}}<br>
            <strong>Earned Points: </strong>{{$userDetails->earned_point}}<br>
            <strong>Points Due: </strong>{{$userDetails->point_due}}<br>

        @endif
    </div>




    <div class="card col-md-4 pt-3 pb-3">
        @if(count($completedTasks) == 0)
            No Completed Tasks
        @else
            <h5><strong>Completed Tasks</strong></h5>
            <hr>

            <table width="100%">
                <tr>
                    <th>Title</th>
                    <th>Total Point</th>
                </tr>
                @foreach($completedTasks as $completedTask)
                    <tr>
                        <td>
                            {{$completedTask->title}}
                        </td>
                        <td>{{$completedTask->point}}</td>
                    </tr>
                @endforeach
            </table>
        @endif

    </div>
@endsection
