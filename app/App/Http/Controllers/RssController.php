<?php

namespace App\Http\Controllers;

use App\Http\Queries\LastMonthPostsQuery;
use Domain\Post\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

final class RssController
{
    public function feed(
        Request $request,
        LastMonthPostsQuery $query
    ): Collection {
        $tags = collect((array) $request->get('tags', $request->get('tag')))
            ->flatMap(fn(string $tag) => explode(',', $tag));

        if ($tags->isNotEmpty()) {
            $tagCollection = Tag::whereIn('slug', $tags)->get();

            $query->whereTags($tagCollection);
        }

        return $query->get();
    }
}
