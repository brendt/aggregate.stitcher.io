@component('layouts.app', [
    'title' => __('Posts'),
])
    <post-list :posts="$posts" :user="$user"></post-list>
@endcomponent
