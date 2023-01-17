<?php

namespace App\Models;

use App\Http\Controllers\Links\VisitLinkController;
use Brendt\SparkLine\SparkLine;
use Brendt\SparkLine\SparkLineDay;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class Link extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'visits' => 'integer',
    ];

    protected static function booted()
    {
        self::creating(
        /** @phpstan-ignore-next-line */
            fn (Link $link) => $link->uuid ??= Uuid::uuid4()->toString()
        );

        self::saving(function (Link $link) {
            if (! $link->title) {
                $link->title = $link->resolveTitle();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function getRedirectLink(): string
    {
        return action(VisitLinkController::class, $this);
    }

    public function getVisitsGraphCacheKey(): string
    {
        /** @phpstan-ignore-next-line */
        return "link-svg-{$this->uuid}";
    }

    public function getSparkLine(): string
    {
        if (
            app()->environment('production')
            && ($cache = Cache::get($this->getVisitsGraphCacheKey()))
        ) {
            return $cache;
        }

        $days = DB::query()
            ->from((new LinkVisit())->getTable())
            ->selectRaw('`created_at_day`, COUNT(*) as `visits`')
            ->where('link_id', $this->id)
            ->groupBy('created_at_day')
            ->orderByDesc('created_at_day')
            ->limit(20)
            ->get()
            ->map(fn (object $row) => new SparkLineDay(
                count: $row->visits,
                day: Carbon::make($row->created_at_day),
            ));

        $maxValue = DB::query()
            ->selectRaw("COUNT(*) AS `visits`, `created_at_day`, `link_id`")
            ->from((new LinkVisit)->getTable())
            ->groupByRaw('`created_at_day`, `link_id`')
            ->orderByDesc('visits')
            ->limit(1)
            ->get('visits');

        $maxValue = ($maxValue[0] ?? null)?->visits;

        $sparkLine = SparkLine::new($days)
            ->withMaxItemAmount(20)
            ->withMaxValue($maxValue)
            ->make();

        Cache::put(
            $this->getVisitsGraphCacheKey(),
            $sparkLine,
            now()->addDay(),
        );

        return $sparkLine;
    }

    protected function resolveTitle(): ?string
    {
        try {
            $meta = get_meta_tags($this->url);
        } catch (ErrorException) {
            $meta = null;
        }

        return $meta['title']
            ?? $meta['twitter:title']
            ?? $meta['og:title']
            ?? null;
    }
}
