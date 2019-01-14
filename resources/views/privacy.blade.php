@component('layouts.app', [
    'title' => __('Privacy & disclaimer'),
])
    <heading>{{ __('Privacy & disclaimer') }}</heading>

    <div class="content w-4/5">
        {!! $privacy !!}
    </div>
@endcomponent
