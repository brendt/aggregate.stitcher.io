<?php

namespace App\Posts;

use Tempest\Clock\Clock;
use Tempest\Database\Builder\QueryBuilders\SelectQueryBuilder;
use Tempest\Database\IsDatabaseModel;
use Tempest\Database\Virtual;
use Tempest\DateTime\DateTime;
use Tempest\DateTime\FormatPattern;
use Tempest\Router\Bindable;
use function Tempest\get;

final class Post implements Bindable
{
    use IsDatabaseModel;

    public string $title;
    public string $uri;
    public DateTime $createdAt;
    public ?DateTime $publicationDate = null;
    public Source $source;
    public PostState $state = PostState::PENDING;
    public int $visits;
    public int $rank;

    #[Virtual]
    public string $cleanUri {
        get {
            return strtok($this->uri, '?');
        }
    }

    /**
     * @return SelectQueryBuilder<Post>
     */
    public static function published(): SelectQueryBuilder
    {
        return self::select()
            ->where(
                'posts.state = ? AND (posts.publicationDate IS NULL OR posts.publicationDate <= ?)',
                PostState::PUBLISHED,
                get(Clock::class)->now()->format(FormatPattern::SQL_DATE_TIME),
            )
            ->with('source')
            ->where('posts.state = ? AND sources.state = ?', PostState::PUBLISHED, SourceState::PUBLISHED);
    }
}
