<?php

namespace App\Http\ViewModels;

use App\Http\Controllers\AdminTagsController;
use Domain\Post\Models\Tag;
use Domain\Post\Models\Topic;
use Spatie\ViewModels\ViewModel;

class AdminTagViewModel extends ViewModel
{
    /** @var \Domain\Post\Models\Tag|null */
    protected $tag;

    public function __construct(?Tag $tag = null)
    {
        $this->tag = $tag;
    }

    public function tag(): ?Tag
    {
        return $this->tag;
    }

    public function name(): ?string
    {
        return optional($this->tag)->name;
    }

    public function keywords(): ?string
    {
        if (! $this->tag) {
            return null;
        }

        return implode(', ', $this->tag->keywords);
    }

    public function color(): ?string
    {
        return optional($this->tag)->color;
    }

    public function topicOptions(): array
    {
        return Topic::all()
            ->mapWithKeys(fn (Topic $topic) => [$topic->id => $topic->name])
            ->toArray();
    }

    public function storeUrl(): string
    {
        if (! $this->tag) {
            return action([AdminTagsController::class, 'store']);
        }

        return action([AdminTagsController::class, 'update'], $this->tag->slug);
    }
}
