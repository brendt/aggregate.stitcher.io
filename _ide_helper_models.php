<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Link
 *
 * @property int $id
 * @property string $uuid
 * @property string $url
 * @property string|null $title
 * @property int $visits
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link query()
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereVisits($value)
 */
	class Link extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LinkVisit
 *
 * @property int $id
 * @property int $link_id
 * @property \Illuminate\Support\Carbon $created_at_day
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LinkVisit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LinkVisit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LinkVisit query()
 * @method static \Illuminate\Database\Eloquent\Builder|LinkVisit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkVisit whereCreatedAtDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkVisit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkVisit whereLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LinkVisit whereUpdatedAt($value)
 */
	class LinkVisit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Mute
 *
 * @property int $id
 * @property string $text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Mute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mute query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mute whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mute whereUpdatedAt($value)
 */
	class Mute extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Post
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $source_id
 * @property \App\Models\PostState $state
 * @property \App\Models\PostType $type
 * @property string $title
 * @property string|null $body
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $hide_until
 * @property string|null $tweet_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $published_at_day
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $visits
 * @property \Illuminate\Support\Carbon|null $last_comment_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostComment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Services\PostSharing\PostShareCollection<int, \App\Models\PostShare> $pendingShares
 * @property-read int|null $pending_shares_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostShareSnooze> $shareSnoozes
 * @property-read int|null $share_snoozes_count
 * @property-read \App\Services\PostSharing\PostShareCollection<int, \App\Models\PostShare> $shares
 * @property-read int|null $shares_count
 * @property-read \App\Models\Source|null $source
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Post homePage()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereActiveSource()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereHideUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereLastCommentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublishedAtDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTweetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereVisits($value)
 */
	class Post extends \Eloquent implements \Spatie\Feed\Feedable {}
}

namespace App\Models{
/**
 * App\Models\PostComment
 *
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property string $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Post $post
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereUserId($value)
 */
	class PostComment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PostShare
 *
 * @property int $id
 * @property int $post_id
 * @property \App\Services\PostSharing\SharingChannel $channel
 * @property \Illuminate\Support\Carbon $share_at
 * @property \Illuminate\Support\Carbon|null $shared_at
 * @property string|null $reference
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Post $post
 * @method static \App\Services\PostSharing\PostShareCollection<int, static> all($columns = ['*'])
 * @method static \App\Services\PostSharing\PostShareCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|PostShare latestForChannel(\App\Services\PostSharing\SharingChannel $channel)
 * @method static \Illuminate\Database\Eloquent\Builder|PostShare latestForPost(\App\Models\Post $post)
 * @method static \Illuminate\Database\Eloquent\Builder|PostShare newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostShare newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostShare query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostShare whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostShare whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostShare whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostShare whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostShare wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostShare whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostShare whereShareAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostShare whereSharedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostShare whereUpdatedAt($value)
 */
	class PostShare extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PostShareSnooze
 *
 * @property int $id
 * @property int $post_id
 * @property \App\Services\PostSharing\SharingChannel $channel
 * @property \Illuminate\Support\Carbon $snooze_until
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Post $post
 * @method static \Illuminate\Database\Eloquent\Builder|PostShareSnooze newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostShareSnooze newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostShareSnooze query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostShareSnooze whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostShareSnooze whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostShareSnooze whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostShareSnooze wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostShareSnooze whereSnoozeUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostShareSnooze whereUpdatedAt($value)
 */
	class PostShareSnooze extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PostVisit
 *
 * @property int $id
 * @property int $post_id
 * @property \Illuminate\Support\Carbon $created_at_day
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PostVisit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostVisit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostVisit query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostVisit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostVisit whereCreatedAtDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostVisit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostVisit wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostVisit whereUpdatedAt($value)
 */
	class PostVisit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Source
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property \App\Models\SourceState $state
 * @property string|null $twitter_handle
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $last_error_at
 * @property string|null $last_error
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @method static \Database\Factories\SourceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Source newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Source newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Source query()
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereLastError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereLastErrorAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereTwitterHandle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereUrl($value)
 */
	class Source extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tweet
 *
 * @property int $id
 * @property int $tweet_id
 * @property \App\Models\TweetState $state
 * @property \App\Models\TweetFeedType $feed_type
 * @property string $text
 * @property string|null $parsed_text
 * @property string|null $rejection_reason
 * @property string $user_name
 * @property string|null $retweeted_by_user_name
 * @property mixed $payload
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Tweet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tweet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tweet pendingToday()
 * @method static \Illuminate\Database\Eloquent\Builder|Tweet query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tweet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tweet whereFeedType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tweet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tweet whereParsedText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tweet wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tweet whereRejectionReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tweet whereRetweetedByUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tweet whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tweet whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tweet whereTweetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tweet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tweet whereUserName($value)
 */
	class Tweet extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property int|null $invited_by
 * @property string|null $invitation_code
 * @property string|null $name
 * @property string $email
 * @property int $is_admin
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $banned_at
 * @property-read User|null $invitedBy
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserPostVisit> $postVisits
 * @property-read int|null $post_visits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBannedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereInvitationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereInvitedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserPostVisit
 *
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property \Illuminate\Support\Carbon $visited_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserPostVisit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPostVisit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPostVisit query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPostVisit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPostVisit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPostVisit wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPostVisit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPostVisit whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPostVisit whereVisitedAt($value)
 */
	class UserPostVisit extends \Eloquent {}
}

