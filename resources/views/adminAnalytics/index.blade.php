@php
    /** @var \Domain\Source\Models\Source[] $topSources */
    /** @var int $totalViewCount */
    /** @var int $totalVoteCount */
@endphp

@component('layouts.admin', [
    'title' => __('Analytics'),
])
    <x-heading>{{ __('Analytics') }}</x-heading>

    <div class="flex flex-wrap mt-4">
        <div class="lg:w-1/2 lg:pr-4">
            <table class="table padding">
                <thead>
                <tr>
                    <th>{{ __('Source') }}</th>
                    <th class="text-right">
                        <x-sort-link name="view_count">
                            {{ __('Views') }}
                        </x-sort-link>
                    </th>
                    <th class="text-right">
                        <x-sort-link name="vote_count">
                            {{ __('Votes') }}
                        </x-sort-link>
                    </th>
                </tr>
                </thead>

                <tbody>
                @foreach($topSources as $source)
                    <tr>
                        <td>
                            <a href="{{ $source->getAdminUrl() }}" class="link">
                                {{ $source->getName() }}
                            </a>
                        </td>
                            <td class="text-right font-mono text-sm">
                                {{ $source->view_count }}
                            </td>
                            <td class="text-right font-mono text-sm">
                                {{ $source->vote_count }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="py-3 px-4 bg-grey-lighter mt-4">
                <h3 class="font-bold mt-1 mb-1">{{ __('General') }}</h3>

                <table class="table thin">
                    <tbody>
                        <tr>
                            <td>{{ __('Total Views') }}</td>
                            <td class="text-right font-mono text-sm">{{ $totalViewCount }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Total Votes') }}</td>
                            <td class="text-right font-mono text-sm">{{ $totalVoteCount }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Avg. Views / Day (Last month)') }}</td>
                            <td class="text-right font-mono text-sm">{{ $averageViewsPerDay }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Avg. Votes / Day (Last month)') }}</td>
                            <td class="text-right font-mono text-sm">{{ $averageVotesPerDay }}</td>
                        </tr>
                    </tbody>
                </table>

                <h3 class="font-bold mt-4 mb-1">{{ __('Sources') }}</h3>

                <table class="table thin">
                    <tbody>
                        <tr>
                            <td>{{ __('Avg. Views / Source (Last month)') }}</td>
                            <td class="text-right font-mono text-sm">{{ $averageViewsPerSourceLastMonth }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Avg. Votes / Source') }}</td>
                            <td class="text-right font-mono text-sm">{{ $averageVotesPerSource }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Avg. Posts / Source') }}</td>
                            <td class="text-right font-mono text-sm">{{ $averagePostsPerSource }}</td>
                        </tr>
                    </tbody>
                </table>

                <h3 class="font-bold mt-4 mb-1">{{ __('Posts') }}</h3>

                <table class="table thin">
                    <tbody>
                        <tr>
                            <td>{{ __('Avg. Views / Post') }}</td>
                            <td class="text-right font-mono text-sm">{{ $averageViewsPerPost }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Avg. Votes / Post') }}</td>
                            <td class="text-right font-mono text-sm">{{ $averageVotesPerPost }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="lg:w-1/2 lg:pl-4">
            <div class="mt-2 lg-max:hidden">
                <x-source-chart :views-per-day="$viewsPerDay" height="175"></x-source-chart>
            </div>

            <div class="mt-2 lg-max:hidden">
                <x-line-chart
                        :data="$averageViewsPerSourcePerMonth"
                        label="Average views per month"
                        background-color="rgba(135, 149, 10, .2)"
                        border-color="rgba(135, 149, 10, 1)"
                        height="175"
                ></x-line-chart>
            </div>

            <div class="mt-2 lg-max:hidden">
                <x-source-chart :votes-per-day="$votesPerDay" height="175"></x-source-chart>
            </div>
        </div>

        <div class="w-full mt-4">
        </div>

        <div class="w-full mt-4">
        </div>
    </div>
@endcomponent
