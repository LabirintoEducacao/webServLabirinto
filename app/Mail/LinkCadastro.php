<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Sala;

class LinkCadastro extends Mailable
{
    use Queueable, SerializesModels;

    public $sala;
    public $prof;
    public $id;
    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Sala $sala, String $prof, int $id, String $email)
    {
        $this->sala = $sala;
        $this->prof = $prof;
        $this->id = $id;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.cadastro')
                    ->with(['sala' => $this->sala, 'prof' => $this->prof, 'id' => $this->id,'email' => $this->email]);
    }
}
