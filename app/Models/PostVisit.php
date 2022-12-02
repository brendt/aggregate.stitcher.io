<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class PostVisit extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'created_at_day' => 'date'
    ];

    protected static function booted()
    {
        self::creating(fn (PostVisit $postVisit) => $postVisit->created_at_day ??= now());
    }
}
