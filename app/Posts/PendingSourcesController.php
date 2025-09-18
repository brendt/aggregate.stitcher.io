<?php

namespace App\Posts;

use App\Authentication\AdminMiddleware;
use Tempest\View\View;
use Tempest\Router;
use function Tempest\view;

final class PendingSourcesController
{
    #[Router\Post('/sources/deny/{source}', middleware: [AdminMiddleware::class])]
    public function deny(Source $source): View
    {
        $source->state = SourceState::DENIED;
        $source->save();

        return $this->render();
    }

    #[Router\Post('/sources/accept/{source}', middleware: [AdminMiddleware::class])]
    public function publish(Source $source, SyncSource $syncSource): View
    {
        $source->state = SourceState::PUBLISHED;
        $source->save();

        $syncSource($source);

        return $this->render();
    }

    private function render(): View
    {
        $pendingSources = Source::select()
            ->where('state', SourceState::PENDING)
            ->orderBy('id DESC')
            ->limit(5)
            ->all();

        return view('x-pending-sources.view.php', pendingSources: $pendingSources);
    }
}