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

    public function source()
    {
        return $this->user->getPrimarySource() ?? new Source();
    }
}
