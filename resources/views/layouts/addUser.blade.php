@extends('layouts.app')

@section('content')
    <div>

        <h1>Create Project</h1>

        @if ($message = Session::get('messages'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    @endif

    <form method="post" action="{{route('user.store')}}">
    @csrf
        <label>Task Name</label>
        <select name="task_id"  class="form-control select2-multiple">
            <option value=""></option>
            @foreach($tasks as $task)
                <option value="{{$task->id}}">
                    {{$task->name}}
                </option>
    @endforeach
        </select>

            <label>User Name</label>
            <select name="user_id"  class="form-control select2-multiple">
                <option value=""></option>
                @foreach($users as $user)
                    <option value="{{$user->id}}">
                        {{$user->name}}
                    </option>
    @endforeach

            </select>
            <button type="submit">Save</button>

        </form>
    </div>


@endsection
