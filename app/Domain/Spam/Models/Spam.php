<?php


namespace Domain\Spam\Models;

use Domain\Model;
use Domain\Source\Models\Source;
use Domain\Tweet\HasTweets;
use Support\HasUuid;

class Spam extends Model
{
    use HasUuid;

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

}
