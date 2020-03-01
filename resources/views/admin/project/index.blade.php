@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4><strong>Project</strong></h4>
                </div>

                <div class="card-body col-md-12">
                    <div class="row">
                        <div class="card col-md-8 pt-3 pb-3">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link btn btn-dark" href="{{route('admin.project.create')}}">Create Project</a>
                                </li>
                            </ul>

                            <hr>
                            @if(count($runningProjects) == 0)
                                No Project Available
                            @else
                                {{$runningProjects->links()}}
                                <table width="100%">
                                    <tr>
                                        <th>Title</th>
                                        <th>Total Point</th>
                                        <th>Deadline</th>
                                    </tr>
                                    @foreach($runningProjects as $project)
                                        <tr>
                                            <td>
                                                <a href="{{route('admin.project.show', [encrypt($project->id)])}}" class="link-stabilize">{{$project->title}}</a>  
                                            </td>
                                            <td>{{$project->total_point}}</td>
                                            <td>{{$project->deadline}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </div>                        
                        <div class="card col-md-4 pt-3 pb-3">                            
                            @if(count($expiredProjects) == 0)
                                No Expired Project
                            @else
                                <h5><strong>Expired Projects</strong></h5>
                                <hr>
                                {{$expiredProjects->links()}}
                                <table width="100%">
                                    <tr>
                                        <th>Title</th>
                                        <th>Total Point</th>
                                    </tr>
                                    @foreach($expiredProjects as $project)
                                        <tr>
                                            <td>
                                                <a href="{{route('admin.project.show', [encrypt($project->id)])}}" class="link-stabilize">{{$project->title}}</a>  
                                            </td>
                                            <td>{{$project->total_point}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
