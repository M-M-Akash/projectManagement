@extends('layouts.user')

@section('content')


@foreach ($taskDetails as $taskDetail)
    <hr>
    <div id="task-info" class="col-md-12">
        <strong>Project: </strong>{{$taskDetail->project->title}}<br>
        <strong>Title: </strong>{{$taskDetail->title}} <br>
        <strong>Description: </strong>{{$taskDetail->description}} <br>
        <strong>Point: </strong>{{$taskDetail->point}} <br>
        <strong>Deadline: </strong>{{$taskDetail->deadline}} <br>
        <strong>Status: </strong>{{$statusInfo->pivot->status}} <br>
        <form action="{{route('user.task.update', [encrypt($taskDetail->id)])}}" method="post">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-primary">I Agree</button>
        </form>
        <hr>
    </div>
@endforeach



@endsection
