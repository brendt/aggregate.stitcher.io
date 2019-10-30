@php
    /** @var \Domain\Post\Models\Post $post */
    /** @var \Domain\User\Models\User $user */
@endphp

<article
    id="post-vote-{{ $post->uuid }}"
    class="post-card w-full flex items-center py-8 border-b border-grey-lighter {{ $user && $user->votedFor($post) ? 'voted-for' : null }}"
>
    <div class="flex-1">
        <p class="mb-2">
            <a
                class="text-xl font-bold font-title post-link {{ $user && $user->hasViewed($post) ? 'viewed' : '' }}"
                href="{{ action([\App\Http\Controllers\PostsController::class, 'show'], $post) }}"
                target="_blank" rel="noopener noreferrer"
            >
                {{ $post->title }}
            </a>

        </p>

        <div class="text-grey-darkest text-sm">
            <a href="{{ action([\App\Http\Controllers\PostsController::class, 'source'], $post->source->website) }}" class="link">{{ $post->source->website }}</a>
            –
            {{ $post->relative_date }}

            @if ($post->view_count > 0)
                –
                @if ($post->view_count === 1)
                    {{ __(':view_count view', ['view_count' => $post->view_count]) }}
                @else
                    {{ __(':view_count views', ['view_count' => $post->view_count]) }}
                @endif
            @endif

            @if($post->tags->isEmpty())
                <div class="inline ml-1">
                    @livewire('vote-button', $post->id)
                </div>
            @endif

            <div class="post-actions">
                @if ($user)
                    @if(! $user->hasMuted($post->source))
                        –
                        <post-button :action="$post->source->getMuteUrl()" :inline="true">
                            {{ __('Mute source') }}
                        </post-button>
                    @endif
                    @if($user->isAdmin() && ! $post->hasBeenTweeted())
                        –
                        <ajax-button
                            :action="$post->getAdminTweetUrl()"
                        >
                            {{ __('Tweet') }}
                        </ajax-button>
                    @endif
                @endif
            </div>
        </div>

        <div class="flex items-baseline mt-3">
            @if($post->tags->isNotEmpty())
                <p class="text-sm">
                    @foreach ($post->tags as $tag)
                        <tag :tag="$tag" class="mr-2"></tag>
                    @endforeach
                </p>

                <div class="ml-1">
                    @livewire('vote-button', $post->id)
                </div>
            @endif
        </div>
    </div>
</article>
