<?php

namespace App\Models;

use App\Http\Controllers\Links\VisitLinkController;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Link extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'visits' => 'integer',
    ];

    protected static function booted()
    {
        self::creating(
            fn (Link $link) => $link->uuid ??= Uuid::uuid4()->toString()
        );
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function getRedirectLink(): string
    {
        return action(VisitLinkController::class, $this);
    }
}
