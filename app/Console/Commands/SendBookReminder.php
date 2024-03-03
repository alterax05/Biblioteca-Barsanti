<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prestito;
use App\Jobs\SendBookReminderEmail;
use Mail;
use App\Mail\PrestitoScaduto;

class SendBookReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-book-reminder {email? : The email of the user to send the reminder to. If not provided, the reminder will be sent to all users who have not returned the book.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the reminder email to users who have not returned the book.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if($this->argument('email')) {
            Mail::to($this->argument('email'))
                ->send(new PrestitoScaduto('Il nome dell\'utente', 'Il titolo del libro' ));
            return;
        }

        // Retrieve all the prestiti that are expired (i.e., data_fine is null and data_inizio is greater than 3 weeks ago)
        $prestiti = Prestito::whereNull('data_fine')
            ->whereDate('data_inizio', '<', now()->subWeek(3))
            ->with('belongsUser', 'belongsCopia.belongsLibro')
            ->get();
        foreach ($prestiti as $prestito) {
            // Retrieve the user's email
            $email = $prestito->belongsUser->email;
            // Retrieve the book's title
            $titolo = $prestito->belongsCopia->belongsLibro->titolo;
            // Retrieve the user's name
            $name = $prestito->belongsUser->name . ' ' . $prestito->belongsUser->surname;
            // Send the reminder email
            Mail::to($email)
                ->send(new PrestitoScaduto($name, $titolo));
        }
    }
}
