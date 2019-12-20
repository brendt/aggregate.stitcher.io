<?php

namespace App\Admin\ViewModels;

use App\Admin\Controllers\AdminTopicsController;
use Domain\Post\Models\Topic;
use Spatie\ViewModels\ViewModel;

class AdminTopicViewModel extends ViewModel
{
    /** @var \Domain\Post\Models\Topic|null */
    protected $topic;

    public function __construct(?Topic $topic = null)
    {
        $this->topic = $topic;
    }

    public function topic(): ?Topic
    {
        return $this->topic;
    }

    public function name(): ?string
    {
        return optional($this->topic)->name;
    }

    public function storeUrl(): string
    {
        if (! $this->topic) {
            return action([AdminTopicsController::class, 'store']);
        }

        return action([AdminTopicsController::class, 'update'], $this->topic->slug);
    }
}
