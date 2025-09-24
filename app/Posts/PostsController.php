<?php

namespace App\Posts;

use App\Authentication\AdminMiddleware;
use Tempest\Database\Query;
use Tempest\DateTime\DateTime;
use Tempest\DateTime\FormatPattern;
use Tempest\Http\Responses\Redirect;
use Tempest\View\View;
use Tempest\Router;
use Throwable;
use function Tempest\Database\query;
use function Tempest\defer;
use function Tempest\view;

final class PostsController
{
    #[Router\Get('/posts/{post}')]
    public function visit(Post $post): Redirect
    {
        defer(function () use ($post) {
            new Query('UPDATE posts SET visits = visits + 1 WHERE id = ?', [$post->id])->execute();

            try {
                $post->load('source');
                new Query('UPDATE sources SET visits = visits + 1 WHERE id = ?', [$post->source->id])->execute();
            } catch (Throwable) {
                // This is a post without a source
            }
        });

        return new Redirect($post->uri);
    }

    #[Router\Post('/posts/deny/{post}', middleware: [AdminMiddleware::class])]
    public function deny(Post $post): View
    {
        $post->state = PostState::DENIED;
        $post->save();

        return $this->render();
    }

    #[Router\Post('/posts/publish/{post}', middleware: [AdminMiddleware::class])]
    public function publish(Post $post): View
    {
        $post->state = PostState::PUBLISHED;
        $post->publicationDate = DateTime::now();
        $post->save();

        return $this->render();
    }

    #[Router\Post('/posts/queue/{post}', middleware: [AdminMiddleware::class])]
    public function queue(Post $post): View
    {
        $lastFullDay = new Query(<<<SQL
        SELECT publicationDate
        FROM posts
        WHERE publicationDate > :publicationDate
        AND state = :state
        GROUP BY publicationDate
        HAVING COUNT(*) >= 5
        ORDER BY publicationDate DESC
        LIMIT 1;
        SQL)->fetchFirst(
            publicationDate: DateTime::now()->startOfDay()->format(FormatPattern::SQL_DATE_TIME),
            state: PostState::PUBLISHED,
        );

        $nextDate = DateTime::parse($lastFullDay['publicationDate'] ?? 'now')
            ->plusDay()
            ->startOfDay();

        $post->state = PostState::PUBLISHED;
        $post->publicationDate = $nextDate;
        $post->save();

        return $this->render();
    }

    private function render(): View
    {
        $pendingPosts = Post::pending()->limit(5)->all();
        $publishedPostsToday = Post::publishedToday();
        $shouldQueue = $publishedPostsToday >= 5;
        $futureQueued = Post::futureQueued();
        $pendingCount = Post::pendingCount();

        return view(
            'x-pending-posts.view.php',
            pendingPosts: $pendingPosts,
            shouldQueue: $shouldQueue,
            futureQueued: $futureQueued,
            pendingCount: $pendingCount,
        );
    }
}