@component('layouts.app', [
    'title' => __('Privacy & disclaimer'),
])
    <h1 class="font-title text-2xl mt-4 mb-8">
        {{ __('Privacy & disclaimer') }}
    </h1>

    <div class="content">
        {!! $privacy !!}
    </div>
@endcomponent
