<?php

namespace App\Home;

use App\Posts\Post;
use App\Posts\PostState;
use App\Posts\SourceState;
use Tempest\Auth\Authentication\Authenticator;
use Tempest\Clock\Clock;
use Tempest\Database\Query;
use Tempest\DateTime\DateTime;
use Tempest\DateTime\FormatPattern;
use Tempest\Router\Get;
use Tempest\View\View;
use function Tempest\Database\query;
use function Tempest\Support\arr;
use function Tempest\view;

final class HomeController
{
    #[Get('/{page:.?}')]
    public function __invoke(string $page, Authenticator $authenticator, Clock $clock): View
    {
        $currentPage = $page ? intval($page) : 1;

        $page = Post::published()
            ->orderBy('publicationDate DESC')
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
                $localRank = 0;
            } else {
                $localRank = round($rebasedValue / $rebasedMax, 1);
            }

            return match (true) {
                $localRank > 0.9 => 'bg-slate-300',
                $localRank > 0.6 => 'bg-slate-200',
                $localRank > 0.3 => 'bg-slate-100',
                default => 'bg-gray-100',
            };
        };

        /** @var \App\Authentication\User $user */
        $user = $authenticator->current();

        if ($user?->isAdmin) {
            $futureQueued = Post::futureQueued();
            $pendingPosts = Post::pending()->limit(5)->all();
            $publishedPostsToday = Post::publishedToday();
            $shouldQueue = $publishedPostsToday >= 5;
        } else {
            $pendingPosts = [];
            $shouldQueue = null;
        }

        return view(
            'home.view.php',
            user: $user,
            page: $page,
            posts: $posts,
            pendingPosts: $pendingPosts,
            color: $color,
            shouldQueue: $shouldQueue,
            futureQueued: $futureQueued,
        );
    }
}
