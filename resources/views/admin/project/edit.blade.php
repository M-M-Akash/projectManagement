@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h4><strong>Edit </strong>{{$project->title}}</h4></div>

                    <div class="card-body">
                        <form action="{{route('admin.project.update', [encrypt($project->id)])}}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="title">Project Title</label>
                                <input type="text" name="title" id="" class="form-control" value="{{$project->title}}">
                                {{$errors->first('title')}}
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="" cols="30" rows="5" class="form-control">{{$project->description}}</textarea>
                                {{$errors->first('description')}}
                            </div>
                            <div class="form-group">
                                <label for="deadline">Deadline</label>
                                <input type="date" name="deadline" id="" class="form-control" value="{{$project->deadline}}">
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
