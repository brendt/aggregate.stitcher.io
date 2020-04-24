<?php

namespace App\Console\Jobs;

use Carbon\Carbon;
use Domain\Analytics\Actions\CreatePageCacheViewAction;
use Domain\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class PageCacheViewJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $url;

    private Carbon $viewed_at;

    private bool $isCacheHit;

    private ?User $user;

    public static function forRequest(Request $request, bool $isCacheHit): PageCacheViewJob
    {
        return new self(
            parse_url($request->getRequestUri(), PHP_URL_PATH),
            now(),
            $isCacheHit,
            $request->user()
        );
    }

    public function __construct(
        string $url,
        Carbon $viewed_at,
        bool $isCacheHit,
        ?User $user
    ) {
        $this->url = $url;
        $this->viewed_at = $viewed_at;
        $this->isCacheHit = $isCacheHit;
        $this->user = $user;
    }

    public function handle(CreatePageCacheViewAction $createPageCacheViewAction): void
    {
        $createPageCacheViewAction(
            $this->url,
            $this->viewed_at,
            $this->isCacheHit,
            $this->user
        );
    }
}
