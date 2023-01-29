<?php

namespace App\Models;

use App\Actions\ResolveSourceName;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Source extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'state' => SourceState::class,
    ];

    protected static function booted()
    {
        self::creating(function (Source $source) {
            $source->state ??= SourceState::PENDING;

            $source->name ??= (new ResolveSourceName)($source);
        });
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function isExternals(): bool
    {
        return $this->name === 'https://externals.io';
    }

    public function isPublishing(): bool
    {
        return $this->state === SourceState::PUBLISHING;
    }

    public function isPublished(): bool
    {
        return $this->state === SourceState::PUBLISHED;
    }

    public function isDenied(): bool
    {
        return $this->state === SourceState::DENIED;
    }

    public function isPending(): bool
    {
        return $this->state === SourceState::PENDING;
    }

    public function isInvalid(): bool
    {
        return $this->state === SourceState::INVALID;
    }

    public function isDuplicate(): bool
    {
        return $this->state === SourceState::DUPLICATE;
    }

    public function canPublish(): bool
    {
        return ! $this->isPublished();
    }

    public function canDeny(): bool
    {
        return ! $this->isDenied();
    }

    public function canDelete(): bool
    {
        return $this->isDenied();
    }

    public function getBaseUrl(): string
    {
        $parsed = parse_url($this->url);

        return ($parsed['scheme'] ?? 'http') . '://' . $parsed['host'];
    }

    public function hasDuplicate(): bool
    {
        return self::query()
            ->whereNot('id', $this->id)
            ->where('name', $this->getBaseUrl())
            ->exists();
    }
}
