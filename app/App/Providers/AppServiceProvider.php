<?php

namespace App\Providers;

use Abraham\TwitterOAuth\TwitterOAuth;
use Domain\Language\LanguageRepository;
use Domain\Post\Models\Post;
use Domain\Post\Models\Tag;
use Domain\Post\Models\Topic;
use Domain\Post\Models\View;
use Domain\Post\Models\Vote;
use Domain\Source\Models\Source;
use Domain\Tweet\Api\FakeTwitterOAuth;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use Psr\Log\LoggerInterface;
use Spatie\QueryString\QueryString;
use Support\Markdown;
use Support\Rss\Reader;
use Support\Rss\RssReader;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Relation::morphMap(
            [
                'source' => Source::class,
                'post' => Post::class,
                'tag' => Tag::class,
                'view' => View::class,
                'topic' => Topic::class,
                'vote' => Vote::class,
            ]
        );
        Blade::componentNamespace('App\\Components', 'components');

        LengthAwarePaginator::defaultView('layouts.pagination');
    }

    public function register(): void
    {
        $this->app->alias('bugsnag.multi', LoggerInterface::class);

        $this->app->singleton(QueryString::class, function () {
            /** @var \Illuminate\Http\Request $request */
            $request = $this->app->get(Request::class);

            return new QueryString(urldecode($request->getRequestUri()));
        });

        $this->app->singleton(Markdown::class, function () {
            $environment = Environment::createCommonMarkEnvironment();

            $convertor = new CommonMarkConverter([], $environment);

            return new Markdown($convertor);
        });

        $this->app->singleton(Reader::class, fn () => new RssReader());

        $this->app->bind(TwitterOAuth::class, function () {
            if (config('services.twitter.fake')) {
                return new FakeTwitterOAuth();
            }

            return new TwitterOAuth(
                config('services.twitter.consumer_key'),
                config('services.twitter.consumer_secret'),
                config('services.twitter.access_token'),
                config('services.twitter.access_token_secret')
            );
        });

        $this->app->singleton(LanguageRepository::class, fn () => new LanguageRepository(__DIR__ . '/../../languages.json'));
    }
}
