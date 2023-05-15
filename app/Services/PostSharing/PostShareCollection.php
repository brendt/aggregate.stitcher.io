<?php

namespace App\Services\PostSharing;

use App\Models\Post;
use App\Models\PostShare;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Period\Period;

final class PostShareCollection extends Collection
{
    public function forPost(Post $post): self
    {
        return $this->filter(
            fn (PostShare $share) => $share->post_id === $post->id
        );
    }

    public function forPeriod(Period $period): self
    {
        return $this->filter(
            fn (PostShare $share) => $period->contains($share->getDate()),
        );
    }

    public function forChannel(SharingChannel $channel): self
    {
        return $this->filter(
            fn (PostShare $share) => $share->channel === $channel,
        );
    }
}
