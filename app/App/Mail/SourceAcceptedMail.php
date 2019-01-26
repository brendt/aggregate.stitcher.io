<?php

namespace App\Mail;

use Domain\Source\Models\Source;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SourceAcceptedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var \Domain\Source\Models\Source */
    protected $source;

    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    public function build()
    {
        return $this
            ->to($this->source->user->email)
            ->subject(__("Your source is now active"))
            ->markdown('mails.sourceAccepted', [
                'source' => $this->source,
            ]);
    }
}
