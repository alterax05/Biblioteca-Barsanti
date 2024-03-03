<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prestito;
use App\Jobs\SendBookReminderEmail;


class SendBookReminderEmailTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-book-reminder-email-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $prestito = Prestito::find(2); // Sostituisci 1 con l'ID del prestito
    
        dispatch(new SendBookReminderEmail($prestito));
    }
}
