@component('layouts.app', [
    'title' => __('Posts'),
])
    <h1>{{ $title ?? __('Posts') }}</h1>

    <post-list :posts="$posts" :user="$user" :sources="$sources"></post-list>
@endcomponent
