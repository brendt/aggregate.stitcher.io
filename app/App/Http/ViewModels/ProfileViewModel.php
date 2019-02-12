<?php
namespace App\Http\ViewModels;

use Domain\User\Models\User;
use Spatie\ViewModels\ViewModel;

class ProfileViewModel extends ViewModel
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
