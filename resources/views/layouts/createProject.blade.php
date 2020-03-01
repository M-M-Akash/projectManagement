@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="container">

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

            <form method="post" action="{{route('project.store')}}">
                @csrf
                <div class="form-group">
                    <label>Project Name</label>
                    <input type="text" name="name" value="" class="form-control">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea type="textarea" name="description" class="form-control"></textarea>
                </div>
                <button class="btn btn-primary" type="submit">Save</button>
            </form>
        </div>
    </div>

@endsection

