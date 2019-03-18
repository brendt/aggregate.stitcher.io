<?php

namespace App\Http\ViewModels;

use Domain\Post\Models\Topic;
use Spatie\ViewModels\ViewModel;

class GuestSourceViewModel extends ViewModel
{
    public function topicOptions(): array
    {
        return Topic::all()
            ->mapWithKeys(function (Topic $topic) {
                return [$topic->id => $topic->name];
            })
            ->prepend(__('-'), null)
            ->toArray();
    }
}
