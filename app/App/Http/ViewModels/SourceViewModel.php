<?php

namespace App\Http\ViewModels;

use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Spatie\ViewModels\ViewModel;

class SourceViewModel extends ViewModel
{
    /** @var \Domain\User\Models\User */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function source(): ?Source
    {
        return $this->user->getPrimarySource();
    }

    public function url(): ?string
    {
        return optional($this->source())->url;
    }

    public function twitterHandle(): ?string
    {
        return optional($this->source())->twitter_handle;
    }
}
