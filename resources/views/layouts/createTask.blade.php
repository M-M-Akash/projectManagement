@extends('layouts.app')

@section('content')
    <div>

        <h1>Create Task</h1>

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

        <form method="post" action="{{route('task.store')}}">
            @csrf
            <label>Project Name</label>
            <select name="project_id" class="form-control select2-multiple">
                <option value=""></option>
                @foreach($projects as $project)
                    <option value="{{$project->id}}">
                        {{$project->name}}
                    </option>
                @endforeach
            </select>
            <br>
            <label>Task Name</label>
            <br>
            <input type="text" name="name" value="">
            <br>
            <button type="submit">Save</button>
        </form>
    </div>

@endsection
