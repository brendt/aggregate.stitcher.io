@php
    /** @var \Domain\Source\Models\Source[] $sources */
    /** @var \Domain\Post\Models\Post[] $posts */
    /** @var \Domain\User\Models\User $user */
    /** @var \Domain\Post\Models\Tag|null $currentTag */
@endphp

{{-- <div>
    @if($user)
        <a href="{{ filter('unread') }}"
           class="
                tag
                inline-block
                p-2 pt-1 pb-1
                border
                {{ filter_active('unread') ? 'active' : '' }}
               "
           style="--tag-color: #000"
        >
            {{ __('Unread') }}
        </a>
    @endif

    @foreach($sources as $source)
        <a href="{{ filter('sources.website[]', $source) }}">
            {{ $source->website }}
        </a>
    @endforeach

    @if (filter_active('sources.website[]'))
        <a href="{{ clear_filter('sources.website[]') }}">
            {{ __('clear') }}
        </a>
    @endif
</div> --}}

@isset($currentTag)
    <p class="text-xl mt-4">
        <tag :tag="$currentTag" class="mr-1/2"></tag>
    </p>

    @if ($user)
        @if(! $user->hasMuted($currentTag))
            <post-button
                :action="$currentTag->getMuteUrl()"
            >
                    <span class="
                        underline
                        text-grey text-sm
                        hover:no-underline
                    ">
                        {{ __('Mute tag') }}
                    </span>
            </post-button>
        @endif
    @endif
@endisset

<section class="py-2">
    @foreach($posts as $post)
        <post-card
            :post="$post"
            :user="$user"
            :last="$loop->last"
        ></post-card>
    @endforeach

    @if($posts->isEmpty())
        {{ __('Nothing to see here!') }}
    @endif
</section>

<div class="mt-4 mb-4">
    {{ $posts->render() }}
</div>
