<?php

namespace Domain\Post\Events;

use App\Domain\Post\DTO\PostData;
use Carbon\Carbon;
use Domain\Post\Models\Post;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\EventProjector\ShouldBeStored;

class UpdatePostEvent extends DataTransferObject implements ShouldBeStored
{
    /** @var string */
    public $post_uuid;

    /** @var array */
    public $post_data;

    public function __construct(string $post_uuid, array $post_data)
    {
        $post_data['date_created'] = $post_data['date_created'] instanceof Carbon
            ? $post_data['date_created']->toDateTimeString()
            : $post_data['date_created'];

        parent::__construct([
            'post_uuid' => $post_uuid,
            'post_data' => $post_data,
        ]);
    }

    public static function create(Post $post, PostData $postData): UpdatePostEvent
    {
        return new self(
            $post->uuid,
            $postData->all()
        );
    }
}
