<?php

namespace App\Mail;

use App\Models\Source;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SourceAddedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Source $source,
    ) {
    }

    public function build()
    {
        return $this->markdown('mail.sourceAdded', [
            'source' => $this->source,
        ]);
    }
}
