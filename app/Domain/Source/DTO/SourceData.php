<?php

namespace Domain\Source\DTO;

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

    public static function fromRequest(
        SourceRequest $request,
        ?Source $source = null
    ): SourceData {
        return new self([
            'url' => $request->getSourceUrl(),
            'is_active' => $source->is_active ?? false,
            'twitter_handle' => self::formatTwitterHandle($request->getTwitterHandle())
        ]);
    }

    public function hasChanges(Source $source): bool
    {
        return
            $source->url !== $this->url
            || $source->twitter_handle !== $this->twitter_handle;
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
