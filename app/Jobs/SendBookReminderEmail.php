<?php

namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class BookReminderEmail extends Mailable
{
  use Queueable, InteractsWithQueue, SerializesModels;
    public $prestito;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Prestito $prestito
     * @return void
     */

    public function __construct(\App\Models\Prestito $prestito)
    {
        $this->prestito = $prestito;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $utente = $this->prestito->utente;
    
        return $this->view('emails.book_reminder')
            ->subject('Promemoria di consegna libro')
            ->with([
                'utente' => $utente,
                'prestito' => $this->prestito,
            ]);
    }    
}

class SendBookReminderEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Il prestito in questione.
     *
     * @var \App\Models\Prestito
     */
    protected $prestito;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\Prestito $prestito
     */
    public function __construct(\App\Models\Prestito $prestito)
    {
        $this->prestito = $prestito;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $utente = $this->prestito->utente;
        Mail::to($utente->email)
            ->send(new BookReminderEmail($this->prestito));
    }
}

