<?php

namespace App\Posts;

use Tempest\Database\Builder\QueryBuilders\SelectQueryBuilder;
use Tempest\Database\IsDatabaseModel;
use Tempest\Database\Virtual;
use Tempest\DateTime\DateTime;
use Tempest\Router\Bindable;

final class Post implements Bindable
{
    use IsDatabaseModel;

    public string $title;
    public string $uri;
    public DateTime $createdAt;
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
            ->with('source')
            ->where('posts.state = ? AND sources.state = ?', PostState::PUBLISHED, SourceState::PUBLISHED);
    }
}
