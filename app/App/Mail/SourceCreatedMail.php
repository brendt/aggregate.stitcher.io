<?php

namespace App\Mail;

use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SourceCreatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var \Domain\Source\Models\Source */
    protected $source;

    /** @var \Domain\User\Models\User */
    protected $admin;

    public function __construct(Source $source, User $admin)
    {
        $this->source = $source;
        $this->admin = $admin;
    }

    public function build()
    {
        return $this
            ->to($this->admin->email)
            ->subject(__("A new source was added"))
            ->markdown('mails.sourceAdded', [
                'source' => $this->source,
            ]);
    }
}
