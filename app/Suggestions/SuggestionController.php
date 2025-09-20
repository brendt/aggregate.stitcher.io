<?php

namespace App\Suggestions;

use App\Authentication\AdminMiddleware;
use Tempest\View\View;
use Tempest\Router;
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
        // TODO
        return $this->render();
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