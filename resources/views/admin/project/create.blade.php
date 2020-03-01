@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h4>Create Project</h4></div>

                <div class="card-body">
                    <form action="{{route('admin.project.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="" class="form-control" value="{{old('title')}}">
                            {{$errors->first('title')}}
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="" cols="30" rows="5" class="form-control">{{old('description')}}</textarea>
                            {{$errors->first('description')}}
                        </div>
                        <div class="form-group">
                            <label for="deadline">Deadline</label>
                            <input type="date" name="deadline" id="" class="form-control" value="{{old('deadline')}}">
                            {{$errors->first('deadline')}}
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
