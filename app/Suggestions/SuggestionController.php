<?php

namespace App\Suggestions;

use App\Authentication\AdminMiddleware;
use Tempest\DateTime\DateTime;
use Tempest\Http\Responses\Redirect;
use Tempest\View\View;
use Tempest\Router;
use function Tempest\defer;
use function Tempest\Router\uri;
use function Tempest\view;

final readonly class SuggestionController
{
    #[Router\Post('/suggestions/deny/{suggestion}', middleware: [AdminMiddleware::class])]
    public function deny(Suggestion $suggestion): View
    {
        $suggestion->delete();

        return $this->render();
    }

    #[Router\Post('/suggestions/publish/{suggestion}', middleware: [AdminMiddleware::class])]
    public function publish(Suggestion $suggestion): View
    {
        return $this->render();
    }

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
            // resolve feed uri
        });

        return new Redirect('/?success');
    }

    private function render(): View
    {
        $suggestions = Suggestion::select()->all();

        return view(
            'x-pending-posts.view.php',
            suggestions: $suggestions,
        );
    }

}