<?php

namespace App\Posts;

use App\Authentication\AdminMiddleware;
use Tempest\Database\Query;
use Tempest\Http\Responses\Redirect;
use Tempest\View\View;
use Tempest\Router;
use function Tempest\view;

final class PostsController
{
    #[Router\Get('/posts/{post}')]
    public function visit(Post $post): Redirect
    {
        $post->load('source');
        new Query('UPDATE posts SET visits = visits + 1 WHERE id = ?', [$post->id])->execute();
        new Query('UPDATE sources SET visits = visits + 1 WHERE id = ?', [$post->source->id])->execute();

        return new Redirect($post->uri);
    }

    #[Router\Post('/posts/deny/{post}', middleware: [AdminMiddleware::class])]
    public function deny(Post $post): View
    {
        $post->state = PostState::DENIED;
        $post->save();

        return $this->render();
    }

    #[Router\Post('/posts/accept/{post}', middleware: [AdminMiddleware::class])]
    public function accept(Post $post): View
    {
        $post->state = PostState::PUBLISHED;
        $post->save();

        return $this->render();
    }

    private function render(): View
    {
        $pendingPosts = Post::select()
            ->where('posts.state = ? AND sources.state = ?', PostState::PENDING, SourceState::PUBLISHED)
            ->orderBy('createdAt DESC')
            ->limit(5)
            ->with('source')
            ->all();

        return view('x-pending-posts.view.php', pendingPosts: $pendingPosts);
    }
}