<?php

namespace App\Admin;

use App\Authentication\AdminMiddleware;
use App\Posts\Source;
use App\Posts\SourceState;
use Tempest\Http\Request;
use Tempest\Router;
use Tempest\View\View;
use function Tempest\view;

final class AdminController
{
    #[Router\Get('/admin', middleware: [AdminMiddleware::class])]
    public function admin(): View
    {
        return view(
            'admin.view.php',
            ...$this->data(),
        );
    }

    #[Router\Post('/admin/search', middleware: [AdminMiddleware::class])]
    public function search(Request $request): View
    {
        $filter = $request->get('filter');

        $query = Source::select()
            ->orderBy('id DESC');

        if (! $filter) {
            $query->where('state', SourceState::PUBLISHED);
        } else {
            $query
                ->where(
                    'name LIKE :filter OR uri LIKE :filter',
                    filter: "%{$filter}%",
                );
        }

        $sources = $query->limit(20)->all();

        return view(
            '../Posts/x-sources-search-result.view.php',
            sources: $sources,
        );
    }

    
    private function render(): View
    {
        return view(
            'x-admin.view.php',
            ...$this->data(),
        );
    }

    private function data(): array
    {
        return [
        ];
    }
}