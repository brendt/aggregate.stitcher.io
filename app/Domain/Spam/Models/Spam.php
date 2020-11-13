<?php


namespace Domain\Spam\Models;

use Domain\Model;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\HasUuid;

class Spam extends Model
{
    use HasUuid;

    public function source(): belongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
