@component('layouts.app', [
    'title' => __('Make a suggestion'),
])
    <div class="content">
        <h1 class="font-title text-2xl mt-4 mb-8">
            {{ __('Suggest a feed') }}
        </h1>

        <p>
            {!! __("
                Thanks for your suggestion! We'll review this RSS feed and add it if possible!
                Meanwhile, you can read lots of good content <a href=\":url\" class=\"link\">here</a>.
            ", [
                'url' => action([\App\Feed\Controllers\PostsController::class, 'index'])
            ]) !!}
        </p>
    </div>
@endcomponent
