<?php

namespace Tests\Domain\Post\Models;

use App\Feed\Queries\LastMonthPostsQuery;
use Carbon\Carbon;
use Domain\Post\Models\Post;
use Domain\Post\Models\PostTag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Tests\TestCase;

class LastMonthPostQueryTest extends TestCase
{
    /** @test */
    public function shows_posts_for_last_month(): void
    {
        factory(Post::class, 2)->create([
            'date_created' => Carbon::make('-1 week'),
        ]);

        factory(Post::class)->create([
            'date_created' => Carbon::make('-2 months'),
        ]);

        $query = new LastMonthPostsQuery(new Request());

        $this->assertEquals(2, $query->count());
    }

    /** @test */
    public function can_filter_on_tags(): void
    {
        $this->createPostWithTagId(1);
        $this->createPostWithTagId(1);
        $this->createPostWithTagId(2);

        $query = new LastMonthPostsQuery(new Request());
        $topics = new Collection([['id' => 1]]);
        $query->whereTags($topics);

        $this->assertEquals(2, $query->count());
    }

    private function createPostWithTagId(int $tagId): void
    {
        $somePost = factory(Post::class)->create([
            'date_created' => Carbon::make('-1 week'),
        ]);
        factory(PostTag::class)->create([
            'tag_id' => $tagId,
            'post_id' => $somePost->id,
        ]);
    }
}
