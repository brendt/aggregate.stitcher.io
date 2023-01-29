<?php

namespace App\Http\Controllers\Links;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class AdminLinksController
{
    public function __invoke(Request $request)
    {
        $thisWeek = now()->subWeek();

        $links = collect(DB::select(DB::raw(<<<SQL
                SELECT *
                FROM links
                LEFT OUTER JOIN (
                        SELECT link_id, COUNT(*) AS visits_this_week FROM link_visits
                    WHERE created_at_day >= "$thisWeek"
                    GROUP BY link_id
                    HAVING visits_this_week > 50
                ) AS lc ON lc.link_id = links.id
                ORDER BY
                    visits_this_week DESC,
                    created_at DESC
            SQL)))
        ->map(fn (object $data) => new Link((array) $data));

        return view('adminLinks', [
            'links' => $links,
            'message' => $request->get('message'),
        ]);
    }
}
