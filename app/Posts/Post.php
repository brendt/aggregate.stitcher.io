<?php

namespace App\Posts;

use Tempest\Clock\Clock;
use Tempest\Database\Builder\QueryBuilders\SelectQueryBuilder;
use Tempest\Database\IsDatabaseModel;
use Tempest\Database\Virtual;
use Tempest\DateTime\DateTime;
use Tempest\DateTime\FormatPattern;
use Tempest\Router\Bindable;
use function Tempest\Database\query;
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

    /**
     * @return SelectQueryBuilder<Post>
     */
    public static function pending(): SelectQueryBuilder
    {
        return self::select()
            ->with('source')
            ->where('posts.state = ? AND sources.state = ?', PostState::PENDING, SourceState::PUBLISHED)
            ->orderBy('createdAt DESC');
    }

    public static function publishedToday(): int
    {
        return query(self::class)
            ->select('COUNT(*) as count')
            ->join('sources ON sources.id = posts.source_id')
            ->where('posts.state = ?', PostState::PUBLISHED)
            ->where('sources.state = ?', SourceState::PUBLISHED)
            ->where(
                'posts.publicationDate >= ? AND posts.publicationDate < ?',
                DateTime::now()->startOfDay()->format(FormatPattern::SQL_DATE_TIME),
                DateTime::now()->plusDay()->startOfDay()->format(FormatPattern::SQL_DATE_TIME),
            )
            ->groupBy('DATE_FORMAT(posts.publicationDate, "YYYY-MM-DD")')
            ->build()
            ->fetchFirst()['count'] ?? 0;
    }
}
