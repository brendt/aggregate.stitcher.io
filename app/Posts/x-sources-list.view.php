<?php

use App\Posts\Source;
use App\Posts\SourceState;
use App\Admin\AdminController;

?>

<div id="sources-list" class="grid gap-2">
    <input type="search"
            name="filter"
            placeholder="Search…"
            :hx-post="uri([AdminController::class, 'search'])"
            hx-trigger="input changed delay:500ms, keyup[key=='Enter'], load"
            hx-target="#search-results"
            hx-indicator=".htmx-indicator">

    <x-sources-search-result />
</div>