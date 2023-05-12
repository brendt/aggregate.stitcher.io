<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class UserPostVisit extends Model
{
    public $guarded = [];

    protected $casts = [
        'visited_at' => 'datetime',
    ];
}
