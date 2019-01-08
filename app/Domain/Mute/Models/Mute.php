<?php

namespace Domain\Mute\Models;

use App\Domain\Mute\Muteable;
use App\Support\HasUuid;
use Domain\Model;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Mute extends Model
{
    use HasUuid;

    public static function make(User $user, Muteable $muteable): Mute
    {
        $mute = new self([
            'user_id' => $user->id,
            'muteable_type' => $muteable->getMuteableType(),
            'muteable_uuid' => $muteable->getUuid(),
        ]);

        $mute->save();

        return $mute;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function muteable(): MorphTo
    {
        return $this->morphTo('muteable', 'muteable_type', 'muteable_uuid', 'uuid');
    }

    public function scopeWhereUser(Builder $builder, User $user): Builder
    {
        return $builder->where('user_id', $user->id);
    }

    public function scopeWhereMuteable(Builder $builder, Muteable $muteable): Builder
    {
        return $builder
            ->where('muteable_uuid', $muteable->getUuid())
            ->where('muteable_type', $muteable->getMuteableType());
    }

    public function muteableEquals(Muteable $muteable): bool
    {
        return $this->muteable_type === $muteable->getMuteableType()
            && $this->muteable_uuid === $muteable->getUuid();
    }

    public function getMuteable(): Muteable
    {
        return $this->muteable;
    }
}
