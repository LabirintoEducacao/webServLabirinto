<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LinkSala extends Mailable
{
    use Queueable, SerializesModels;

    public $sala;
    public $prof;
    public $id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $sala, String $prof, int $id)
    {
        $this->sala = $sala;
        $this->prof = $prof;
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.sala')
                    ->with(['sala' => $this->sala, 'prof' => $this->prof, 'id' => $this->id]);
    }
}
