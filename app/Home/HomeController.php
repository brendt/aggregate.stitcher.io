<?php

namespace App\Home;

use App\Posts\Post;
use App\Suggestions\Suggestion;
use Tempest\Auth\Authentication\Authenticator;
use Tempest\DateTime\DateTime;
use Tempest\DateTime\FormatPattern;
use Tempest\Http\Request;
use Tempest\Router\Get;
use Tempest\View\View;
use function Tempest\Support\arr;
use function Tempest\view;

final class HomeController
{
    #[Get('/{page:.?}')]
    public function home(string $page, Authenticator $authenticator, Request $request): View
    {
        $currentPage = $page ? intval($page) : 1;

        $page = Post::published()
            ->orderBy('publicationDate DESC')
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

        $color = fn (Post $post) => $this->color($post, $maxVisits, $minVisits);

        /** @var \App\Authentication\User $user */
        $user = $authenticator->current();

        if ($user?->isAdmin) {
            $futureQueued = Post::futureQueued();
            $pendingPosts = Post::pending()->limit(5)->all();
            $publishedPostsToday = Post::publishedToday();
            $shouldQueue = $publishedPostsToday >= 5;
            $pendingCount = Post::pendingCount();
            $suggestions = Suggestion::select()->all();
        }

        return view(
            'home.view.php',
            user: $user,
            page: $page,
            posts: $posts,
            color: $color,
            pendingPosts: $pendingPosts ?? [],
            shouldQueue: $shouldQueue ?? null,
            futureQueued: $futureQueued ?? null,
            pendingCount: $pendingCount ?? null,
            suggestions: $suggestions ?? [],
            success: $request->has('success'),
        );
    }

    #[Get('/top')]
    public function top(Authenticator $authenticator): View
    {
        $posts = arr(Post::published()
            ->orderBy('posts.visits DESC')
            ->where('publicationDate > ?', DateTime::now()->minusDays(7)->startOfDay()->format(FormatPattern::SQL_DATE_TIME))
            ->limit(20)
            ->all());

        $maxVisits = $posts->reduce(
            fn (int $max, Post $post) => max($max, $post->visits),
            0,
        );

        $minVisits = $posts->reduce(
            fn (int $min, Post $post) => min($min, $post->visits),
            0,
        );

        $color = fn (Post $post) => $this->color($post, $maxVisits, $minVisits);

        return view(
            'home.view.php',
            posts: $posts,
            color: $color,
            pendingPosts: $pendingPosts ?? [],
            shouldQueue: $shouldQueue ?? null,
            futureQueued: $futureQueued ?? null,
            pendingCount: $pendingCount ?? null,
            suggestions: $suggestions ?? [],
            user: $authenticator->current(),
            page: null,
        );
    }

    public function color(Post $post, int $maxVisits, int $minVisits): string
    {
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
    }
}
