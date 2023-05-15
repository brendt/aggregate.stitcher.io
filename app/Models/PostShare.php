<?php

namespace App\Models;

use App\Services\PostSharing\PostShareCollection;
use App\Services\PostSharing\SharingChannel;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostShare extends Model
{
    protected $guarded = [];

    protected $casts = [
        'share_at' => 'datetime',
        'shared_at' => 'datetime',
        'channel' => SharingChannel::class,
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function scopeLatestForChannel(Builder $builder, SharingChannel $channel): void
    {
        $builder
            ->where('channel', $channel)
            ->orderByDesc('shared_at')
            ->orderByDesc('share_at')
        ;
    }

    public function scopeLatestForPost(Builder $builder, Post $post): void
    {
        $builder
            ->where('post_id', $post->id)
            ->orderByDesc('shared_at')
            ->orderByDesc('share_at')
        ;
    }

    public function getShareLink(): string
    {
        return $this->channel->getShareLink($this->post);
    }

    public function getDate(): CarbonImmutable
    {
        return ($this->shared_at ?? $this->share_at)->toImmutable();
    }

    public function newCollection(array $models = []): PostShareCollection
    {
        return new PostShareCollection($models);
    }
}
