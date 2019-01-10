<?php

namespace App\Http\ViewModels;

use Domain\Post\Models\Tag;
use Domain\Post\Models\Topic;
use Domain\User\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\ViewModels\ViewModel;

final class PostsViewModel extends ViewModel
{
    /** @var \Illuminate\Pagination\LengthAwarePaginator */
    protected $posts;

    /** @var \Domain\User\Models\User|null */
    protected $user;

    /** @var string|null */
    protected $topicSlug;

    /** @var string|null */
    protected $tagSlug;

    /** @var string|null */
    private $title;

    public function __construct(
        LengthAwarePaginator $posts,
        ?User $user = null
    ) {
        $this->posts = $posts;
        $this->user = $user;
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

    public function title(): ?string
    {
        return $this->title;
    }
}
