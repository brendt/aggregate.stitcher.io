<?php

namespace Domain\Source\DTO;

use App\Http\Requests\AdminSourceRequest;
use App\Http\Requests\SourceRequest;
use Domain\Source\Models\Source;
use Spatie\DataTransferObject\DataTransferObject;

final class SourceData extends DataTransferObject
{
    /** @var string */
    public $url;

    /** @var string|null */
    public $twitter_handle;

    /** @var bool */
    public $is_active;

    /** @var bool */
    public $is_validated;

    /** @var int[] */
    public $topic_ids = [];

    /** @var string|null */
    public $language;

    public static function fromRequest(
        SourceRequest $request,
        ?Source $source = null
    ): SourceData {
        return new self([
            'url' => $request->getSourceUrl(),
            'is_active' => $source->is_active ?? false,
            'is_validated' => $source->is_validated ?? false,
            'language' => $request->get('language'),
            'twitter_handle' => self::formatTwitterHandle($request->getTwitterHandle()),
            'topic_ids' => collect($request->getTopicIds())->filter()->map(function ($id) {
                return (int) $id;
            })->toArray(),
        ]);
    }

    public static function fromAdminRequest(
        AdminSourceRequest $request
    ): SourceData {
        return new self([
            'url' => $request->getSourceUrl(),
            'is_active' => (bool) $request->get('is_active'),
            'is_validated' => (bool) $request->get('is_validated'),
            'language' => $request->get('language') ?? 'en',
            'twitter_handle' => self::formatTwitterHandle($request->getTwitterHandle()),
            'topic_ids' => collect($request->getTopicIds())->filter()->map(function ($id) {
                return (int) $id;
            })->toArray(),
        ]);
    }

    public function hasChanges(Source $source): bool
    {
        return
            $source->url !== $this->url
            || $source->is_active !== $this->is_active
            || $source->is_validated !== $this->is_validated
            || $source->language !== $this->language
            || $source->twitter_handle !== $this->twitter_handle
            || $source->topics->pluck('id') !== $this->topic_ids;
    }

    private static function formatTwitterHandle(?string $twitterHandle): ?string
    {
        if (! $twitterHandle) {
            return null;
        }

        if (strpos($twitterHandle, '@') === 0) {
            return $twitterHandle;
        }

        return "@{$twitterHandle}";
    }
}
