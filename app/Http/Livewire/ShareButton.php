<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\PostShare;
use App\Services\PostSharing\SharingChannel;
use Livewire\Component;

class ShareButton extends Component
{
    protected $listeners = ['handleKeypress'];

    public bool $modalShown = false;

    public array $form = [];

    public Post $post;

    public ?SharingChannel $channelFilter = null;

    public ?PostShare $postShare = null;

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

    public function storeForm(): void
    {
        $channel = $this->getChannel();

        if (! $channel) {
            return;
        }

        $this->postShare = PostShare::create([
            'channel' => $channel,
            'post_id' => $this->post->id,
            'share_at' => $channel->getSchedule()->getNextTimeslot($this->post),
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

    public function handleKeypress(string $key): void
    {
        match($key) {
            'Escape' => $this->hideModal(),
            default => null,
        };
    }
}
