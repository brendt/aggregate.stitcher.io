<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class LinkVisit extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'created_at_day' => 'date'
    ];

    protected static function booted()
    {
        self::creating(fn (LinkVisit $linkVisit) => $linkVisit->created_at_day ??= now());
    }
}
