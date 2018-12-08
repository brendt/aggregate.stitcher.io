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

    /** @var int[] */
    public $tag_ids;

    public function __construct(string $post_uuid, array $post_data, array $tag_ids)
    {
        $post_data['date_created'] = $post_data['date_created'] instanceof Carbon
            ? $post_data['date_created']->toDateTimeString()
            : $post_data['date_created'];

        parent::__construct([
            'post_uuid' => $post_uuid,
            'post_data' => $post_data,
            'tag_ids' => $tag_ids,
        ]);
    }

    public static function new(Post $post, PostData $postData): UpdatePostEvent
    {
        return new self(
            $post->uuid,
            $postData->fillable(),
            $postData->tag_ids
        );
    }
}
