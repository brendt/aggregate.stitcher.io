<?php

namespace App\Http\ViewModels;

use Domain\Post\Models\Tag;
use Domain\Post\Models\Topic;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\ViewModels\ViewModel;

final class PostsViewModel extends ViewModel
{
    /** @var \Illuminate\Pagination\LengthAwarePaginator */
    private $posts;

    /** @var \Domain\User\Models\User|null */
    private $user;

    /** @var string|null */
    private $topicSlug;

    /** @var string|null */
    private $tagSlug;

    /** @var string|null */
    private $title;

    /** @var string|null */
    private $sourceWebsite;

    public function __construct(
        LengthAwarePaginator $posts,
        ?User $user = null
    ) {
        $this->posts = $posts;
        $this->user = $user;
    }

    public function showLandingPage(): bool
    {
        return true;
    }

    public function withTitle(string $title): PostsViewModel
    {
        $this->title = $title;

        return $this;
    }

    public function withTopicSlug(?string $topicSlug): PostsViewModel
    {
        $this->topicSlug = $topicSlug;

        return $this;
    }

    public function withTagSlug(?string $tagSlug): PostsViewModel
    {
        $this->tagSlug = $tagSlug;

        return $this;
    }

    public function withSourceWebsite(?string $website): PostsViewModel
    {
        $this->sourceWebsite = $website;

        return $this;
    }

    public function user(): ?User
    {
        return $this->user;
    }

    public function posts(): LengthAwarePaginator
    {
        return $this->posts;
    }

    public function currentTopic(): ?Topic
    {
        if (! $this->topicSlug) {
            return null;
        }

        return Topic::whereSlug($this->topicSlug)->first();
    }

    public function currentTag(): ?Tag
    {
        if (! $this->tagSlug) {
            return null;
        }

        return Tag::whereSlug($this->tagSlug)->first();
    }

    public function currentSource(): ?Source
    {
        if (! $this->sourceWebsite) {
            return null;
        }

        return Source::whereWebsite($this->sourceWebsite)->first();
    }

    public function title(): ?string
    {
        return $this->title;
    }

    public function donationIndex(): int
    {
        return rand(4, $this->posts->count() - 4);
    }
}
