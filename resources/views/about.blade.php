@component('layouts.app', [
    'title' => __('About aggregate'),
])
    <h1 class="font-title text-2xl mt-4 mb-8">
        {{ __('About aggregate') }}
    </h1>

    <div class="content">
        {!! $about !!}
    </div>
@endcomponent
