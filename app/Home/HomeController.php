<?php

namespace App\Home;

use App\Posts\Post;
use App\Posts\PostState;
use App\Posts\SourceState;
use Tempest\Auth\Authentication\Authenticator;
use Tempest\Router\Get;
use Tempest\View\View;
use function Tempest\Support\arr;
use function Tempest\view;

final class HomeController
{
    #[Get('/{page:.?}')]
    public function __invoke(string $page, Authenticator $authenticator): View
    {
        $currentPage = $page ? intval($page) : 1;

        $page = Post::select()
            ->where('state', PostState::PUBLISHED)
            ->orderBy('createdAt DESC')
            ->with('source')
            ->paginate(currentPage: $currentPage);

        $posts = arr($page->data);

        $maxVisits = $posts->reduce(
            fn (int $max, Post $post) => max($max, $post->visits),
            0,
        );

        $minVisits = $posts->reduce(
            fn (int $min, Post $post) => min($min, $post->visits),
            0,
        );

        $color = function (Post $post) use ($maxVisits, $minVisits) {
            $rebasedMax = $maxVisits - $minVisits;
            $rebasedValue = $post->visits - $minVisits;

            if ($rebasedMax === 0) {
                $ratio = 0;
            } else {
                $ratio = round($rebasedValue / $rebasedMax, 1);
            }

            return match(true) {
                $ratio > 0.9 => 'bg-slate-300',
                $ratio > 0.6 => 'bg-slate-200',
                $ratio > 0.3 => 'bg-slate-100',
                default => 'bg-white',
            };
        };

        /** @var \App\Authentication\User $user */
        $user = $authenticator->current();

        if ($user?->isAdmin) {
            $pendingPosts = Post::select()
                ->where('posts.state = ? AND sources.state = ?', PostState::PENDING, SourceState::PUBLISHED)
                ->with('source')
                ->orderBy('createdAt DESC')
                ->limit(5)
                ->all();
        } else {
            $pendingPosts = [];
        }

        return view(
            'home.view.php',
            user: $user,
            page: $page,
            posts: $posts,
            pendingPosts: $pendingPosts,
            color: $color,
        );
    }
}
