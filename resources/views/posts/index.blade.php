@component('layouts.app', [
    'title' => __('Posts'),
])
    <post-list
        :title="$title ?? __('Posts')"
        :posts="$posts"
        :user="$user"
        :sources="$sources"
    ></post-list>
@endcomponent
