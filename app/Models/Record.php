<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = ['user_id', 'task_done', 'earned_point', 'task_due', 'point_due'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
