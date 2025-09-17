<?php

namespace App\Admin;

use App\Authentication\AdminMiddleware;
use App\Posts\Post;
use App\Posts\PostState;
use App\Posts\Source;
use App\Posts\SourceState;
use Tempest\Router;
use Tempest\View\View;
use function Tempest\Database\query;
use function Tempest\view;

final class AdminController
{
    #[Router\Get('/admin', middleware: [AdminMiddleware::class])]
    public function admin(): View
    {
        return view(
            'admin.view.php',
            ...$this->data(),
        );
    }

    #[Router\Post('/admin/deny-all-pending', middleware: [AdminMiddleware::class])]
    public function denyAllPending(): View
    {
        query(Post::class)
            ->update(
                state: PostState::DENIED,
            )
            ->where('state', PostState::PENDING)
            ->execute();

        return $this->render();
    }


    private function render(): View
    {
        return view(
            'x-admin.view.php',
            ...$this->data(),
        );
    }

    private function data(): array
    {
        $pendingPosts = Post::select()
            ->where('state', PostState::PENDING)
            ->orderBy('createdAt DESC')
            ->limit(5)
            ->with('source')
            ->all();

        $pendingSources = Source::select()
            ->where('state', SourceState::PENDING)
            ->orderBy('id DESC')
            ->limit(5)
            ->all();

        return [
            'pendingCount' => query(Post::class)->count()->where('state', PostState::PENDING)->execute(),
            'pendingPosts' => $pendingPosts,
            'pendingSources' => $pendingSources,
        ];
    }
}