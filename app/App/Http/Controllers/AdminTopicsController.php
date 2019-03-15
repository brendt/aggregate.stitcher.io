<?php

namespace App\Http\Controllers;

use App\Http\Queries\AdminTopicsQuery;
use App\Http\Requests\AdminTopicRequest;
use App\Http\ViewModels\AdminTopicViewModel;
use Domain\Post\Actions\CreateTopicAction;
use Domain\Post\Actions\UpdateTopicAction;
use Domain\Post\DTO\TopicData;
use Domain\Post\Models\Topic;
use Illuminate\Http\Request;

class AdminTopicsController
{
    public function index(
        Request $request,
        AdminTopicsQuery $query
    ) {
        $topics = $query->paginate();

        return view('adminTopics.index', [
            'topics' => $topics,
            'currentUrl' => $request->url(),
            'currentSearchQuery' => $request->get('filter')['search'] ?? null,
        ]);
    }

    public function create()
    {
        return (new AdminTopicViewModel())->view('adminTopics.form');
    }

    public function edit(Topic $topic)
    {
        return (new AdminTopicViewModel($topic))->view('adminTopics.form');
    }

    public function store(
        AdminTopicRequest $request,
        CreateTopicAction $createTopicAction
    ) {
        $topicData = TopicData::fromRequest($request);

        $topic = $createTopicAction($topicData);

        flash('Topic created!');

        return action([self::class, 'edit'], $topic);
    }

    public function update(
        AdminTopicRequest $request,
        Topic $topic,
        UpdateTopicAction $updateTopicAction
    ) {
        $topicData = TopicData::fromRequest($request);

        $updateTopicAction($topic, $topicData);

        flash('Topic saved!');

        return redirect()->back();
    }
}
