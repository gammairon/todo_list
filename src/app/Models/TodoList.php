<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    protected $fillable = [
        'title', 'description', 'status'
    ];


    //Relationship======================
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-M-Y');
    }
}
