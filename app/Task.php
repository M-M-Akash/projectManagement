<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable= ['name','project_id'];
    public function project(){
        //tasks belong to project
        return $this->belongsTo(Project::class);
    }
    public function users(){
        //task has many users
        return $this->belongsToMany(User::class);
    }
}
