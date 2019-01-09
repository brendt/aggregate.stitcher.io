<?php

namespace App\Http\ViewModels;

use App\Http\Requests\PostIndexRequest;
use Domain\Post\Models\Tag;
use Domain\Post\Models\Topic;
use Domain\User\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\ViewModels\ViewModel;

final class PostsViewModel extends ViewModel
{
    /** @var \App\Http\Requests\PostIndexRequest */
    private $request;

    /** @var \Illuminate\Pagination\LengthAwarePaginator */
    protected $posts;

    /** @var string */
    private $title;

    public function __construct(
        PostIndexRequest $request,
        LengthAwarePaginator $posts
    ) {
        $this->request = $request;
        $this->posts = $posts;
    }

    public function withTitle(string $title): PostsViewModel
    {
        $this->title = $title;

        return $this;
    }

    public function user(): ?User
    {
        return $this->request->user();
    }

    public function posts(): LengthAwarePaginator
    {
        return $this->posts;
    }

    public function currentTopic(): ?Topic
    {
        $slug = $this->request->getTopicSlug();

        if (! $slug) {
            return null;
        }

        return Topic::whereSlug($slug)->first();
    }

    public function currentTag(): ?Tag
    {
        $slug = $this->request->getTagSlug();

        if (! $slug) {
            return null;
        }

        return Tag::whereSlug($slug)->first();
    }

    public function title(): ?string
    {
        return $this->title;
    }
}
