<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\PostShare;
use App\Services\PostSharing\SharingChannel;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Livewire\Component;

class ShareButton extends Component
{
    protected $listeners = ['handleKeypress'];

    public bool $modalShown = false;

    public array $form = [];

    public Post $post;

    public ?SharingChannel $channelFilter = null;

    public ?PostShare $postShare = null;

    public bool $useCustomDate = false;

    public function mount(): void
    {
        $this->form['channel'] = $this->channelFilter?->value;
    }

    public function render()
    {
        $channel = $this->getChannel();

        return view('livewire.share-button', [
            'channel' => $channel,
        ]);
    }

    public function getNextTimeSlot(): ?CarbonImmutable
    {
        return $this->getChannel()?->getSchedule()->getNextTimeslot($this->post);
    }

    public function storeForm(): void
    {
        $channel = $this->getChannel();

        if (! $channel) {
            return;
        }

        if ($this->form['customDate'] ?? null) {
            $shareAt = Carbon::make($this->form['customDate'])->setHour(11)->setMinute(random_int(1, 20));
        } else {
            $shareAt = $channel->getSchedule()->getNextTimeslot($this->post);
        }

        $this->postShare = PostShare::create([
            'channel' => $channel,
            'post_id' => $this->post->id,
            'share_at' => $shareAt,
        ]);

        $this->hideModal();
        $this->emit('postShareAdded');
    }

    public function getChannel(): ?SharingChannel
    {
        return SharingChannel::tryFrom($this->form['channel'] ?? null);
    }

    public function showModal(): void
    {
        if ($this->modalShown) {
            return;
        }

        $this->modalShown = true;
    }

    public function hideModal(): void
    {
        $this->modalShown = false;
    }

    public function getChannelsProperty(): array
    {
        return SharingChannel::cases();
    }

    public function toggleCustomDate(): void
    {
        $this->useCustomDate = ! $this->useCustomDate;

        if ($this->useCustomDate) {
            $this->form['customDate'] = now()->toDateString();
        } else {
            $this->form['customDate'] = null;
        }
    }

    public function handleKeypress(string $key): void
    {
        match($key) {
            'Escape' => $this->hideModal(),
            default => null,
        };
    }
}
