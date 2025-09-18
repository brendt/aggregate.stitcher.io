<?php

namespace App\Admin;

use App\Authentication\AdminMiddleware;
use App\Posts\Post;
use App\Posts\PostState;
use App\Posts\Source;
use App\Posts\SourceState;
use Tempest\Http\Request;
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

    #[Router\Post('/admin/search', middleware: [AdminMiddleware::class])]
    public function search(Request $request): View
    {
        $filter = $request->get('filter');

        $query = Source::select()
            ->orderBy('id DESC');

        if (! $filter) {
            $query->where('state', SourceState::PUBLISHED);
        } else {
            $query
                ->where(
                    'name LIKE :filter OR uri LIKE :filter',
                    filter: "%{$filter}%",
                )
                ->limit(20);
        }

        $sources = $query->all();

        return view(
            '../Posts/x-sources-search-result.view.php',
            sources: $sources,
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
            ->with('source')
            ->where('posts.state = ? AND sources.state = ?', PostState::PENDING, SourceState::PUBLISHED)
            ->orderBy('createdAt DESC')
            ->limit(5)
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