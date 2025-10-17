<?php

namespace App\Home;

use App\Posts\Post;
use App\Suggestions\Suggestion;
use Closure;
use Tempest\Auth\Authentication\Authenticator;
use Tempest\DateTime\DateTime;
use Tempest\DateTime\FormatPattern;
use Tempest\Http\Request;
use Tempest\Router\Get;
use Tempest\Support\Arr\ImmutableArray;
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
            color: $this->createColorFunction($posts),
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
            ->where('publicationDate > ?', DateTime::now()->minusDays(31)->startOfDay()->format(FormatPattern::SQL_DATE_TIME))
            ->limit(20)
            ->all());

        $posts = $posts->sortByCallback(fn (Post $a, Post $b) => $b->publicationDate <=> $a->publicationDate);

        return view(
            'home.view.php',
            posts: $posts,
            color: $this->createColorFunction($posts),
            pendingPosts: $pendingPosts ?? [],
            shouldQueue: $shouldQueue ?? null,
            futureQueued: $futureQueued ?? null,
            pendingCount: $pendingCount ?? null,
            suggestions: $suggestions ?? [],
            user: $authenticator->current(),
            page: null,
        );
    }

    private function createColorFunction(ImmutableArray $posts): Closure
    {
        $postRating = $posts
            ->sortByCallback(fn (Post $a, Post $b) => $b->visits <=> $a->visits)
            ->values()
            ->mapWithKeys(fn (Post $post, int $index) => yield $post->id->value => $index);

        return fn (Post $post) => $this->color($postRating[$post->id->value] ?? null);
    }

    public function color(?int $index): string
    {
        return match (true) {
            $index === 0 => 'bg-slate-400',
            $index < 4 => 'bg-slate-300',
            $index < 6 => 'bg-slate-200',
            $index <= 10 => 'bg-slate-100',
            default => 'bg-gray-100',
        };
    }
}
