@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h4><strong>Edit </strong>{{$task->title}}</h4></div>

                    <div class="card-body">
                        <form action="{{route('admin.project.task.update', [encrypt($task->id)])}}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="title">Task Title</label>
                                <input type="text" name="title" id="" class="form-control" value="{{$task->title}}">
                                {{$errors->first('title')}}
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="" cols="30" rows="5" class="form-control">{{$task->description}}</textarea>
                                {{$errors->first('description')}}
                            </div>                        
                            <div class="form-group">
                                    <label for="point">Point</label>
                                    <input type="number" name="point" id="" class="form-control" value="{{$task->point}}" min="1" max="{{$taskMaxPoint}}">
                                    {{$errors->first('point')}}
                                </div>
                            <div class="form-group">
                                <label for="deadline">Deadline</label>
                                <input type="date" name="deadline" id="" class="form-control" max="{{$task->project->deadline}}" value="{{$task->deadline}}">
                                {{$errors->first('deadline')}}
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
