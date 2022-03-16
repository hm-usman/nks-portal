<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo('App\User', 'employee_id');
    }
}
