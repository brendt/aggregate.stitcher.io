<?php

namespace App\Suggestions;

use App\Authentication\AdminMiddleware;
use App\Posts\Post;
use App\Posts\PostState;
use App\Posts\Source;
use App\Posts\SourceState;
use App\Posts\SyncSource;
use Tempest\DateTime\DateTime;
use Tempest\Http\Request;
use Tempest\Http\Responses\Redirect;
use Tempest\View\View;
use Tempest\Router;
use function Tempest\defer;
use function Tempest\Router\uri;
use function Tempest\view;

final readonly class SuggestionController
{
    #[Router\Get('/suggest')]
    public function suggest(): View
    {
        return view('suggest.view.php');
    }

    #[Router\Post('/suggest')]
    public function createSuggestion(CreateSuggestionRequest $request): Redirect
    {
        $suggestion = Suggestion::create(
            uri: $request->suggestion,
            suggestedAt: DateTime::now(),
            suggestedBy: '',
        );

        defer(function () use ($suggestion) {
            $feedUri = new FindSuggestionFeedUri()($suggestion->uri);

            if ($feedUri) {
                $suggestion->feedUri = $feedUri;
                $suggestion->save();
            }
        });

        return new Redirect('/?success');
    }

    #[Router\Post('/suggestions/deny/{suggestion}', middleware: [AdminMiddleware::class])]
    public function deny(Suggestion $suggestion): View
    {
        $suggestion->delete();

        return $this->render();
    }

    #[Router\Post('/suggestions/publish/{suggestion}', middleware: [AdminMiddleware::class])]
    public function publish(Suggestion $suggestion, Request $request, SyncSource $syncSource): View
    {
        $publishFeed = $request->has('feed');

        if ($publishFeed) {
            $source = Source::create(
                name: parse_url($suggestion->uri, PHP_URL_HOST),
                uri: $suggestion->feedUri,
                state: SourceState::PUBLISHED,
            );

            $syncSource($source);
        } else {
            $title = get_meta_tags($suggestion->uri);
            $title = $title['title'] ?? $title['og:title'] ?? $title['twitter:title'] ?? $suggestion->uri;

            Post::create(
                title: $title,
                uri: $suggestion->uri,
                createdAt: DateTime::now(),
                publicationDate: DateTime::now(),
                state: PostState::PUBLISHED,
            );
        }

        $suggestion->delete();

        return $this->render();
    }

    private function render(): View
    {
        $suggestions = Suggestion::select()->all();

        return view(
            'x-suggestions.view.php',
            suggestions: $suggestions,
        );
    }
}