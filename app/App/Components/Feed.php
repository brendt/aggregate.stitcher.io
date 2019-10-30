<?php

namespace App\Components;

use Domain\Post\Models\Post;
use Livewire\Component;

class Feed extends Component
{
    public $page = 1;

    public function mount()
    {
        $this->page = request()->query('page', 1);
    }

    public function render()
    {
        $posts = Post::forPage($this->page, 15)->get();

        return view('components.postList', [
            'posts' => $posts,
            'user' => current_user(),
            'hasPreviousPage' => $this->page > 1,
            'donationIndex' => rand(4, $posts->count() - 4),
        ]);
    }


    public function previousPage(): void
    {
        $this->page = $this->page > 1
            ? $this->page - 1
            : $this->page;
    }

    public function nextPage(): void
    {
        $this->page += 1;
    }
}
