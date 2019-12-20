<?php

namespace App\Admin\Controllers;

use App\Admin\Queries\AdminTagsQuery;
use App\Admin\Requests\AdminTagRequest;
use App\Admin\ViewModels\AdminTagViewModel;
use Domain\Post\Actions\CreateTagAction;
use Domain\Post\Actions\UpdateTagAction;
use Domain\Post\DTO\TagData;
use Domain\Post\Models\Tag;
use Illuminate\Http\Request;

class AdminTagsController
{
    public function index(
        Request $request,
        AdminTagsQuery $query
    ) {
        $tags = $query->paginate();

        return view('adminTags.index', [
            'tags' => $tags,
            'currentUrl' => $request->url(),
            'currentSearchQuery' => $request->get('filter')['search'] ?? null,
        ]);
    }

    public function create()
    {
        return (new AdminTagViewModel())->view('adminTags.form');
    }

    public function edit(Tag $tag)
    {
        return (new AdminTagViewModel($tag))->view('adminTags.form');
    }

    public function store(
        AdminTagRequest $request,
        CreateTagAction $createTagAction
    ) {
        $tagData = TagData::fromRequest($request);

        $tag = $createTagAction($tagData);

        flash('Tag created!');

        return redirect()->action([self::class, 'edit'], $tag->slug);
    }

    public function update(
        AdminTagRequest $request,
        Tag $tag,
        UpdateTagAction $updateTagAction
    ) {
        $tagData = TagData::fromRequest($request);

        $updateTagAction($tag, $tagData);

        flash('Tag saved!');

        return redirect()->back();
    }
}
