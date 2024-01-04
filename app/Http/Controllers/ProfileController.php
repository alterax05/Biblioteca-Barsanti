<?php

namespace App\Http\Controllers;

use App\Models\Copia;
use App\Models\Libro;
use App\Models\Preferiti;
use App\Models\Prestito;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController
{
    public function profile() {

        $prestiti = Libro::where('libri.ISBN', '>', 0)
            ->join('copie', 'copie.ISBN', 'libri.ISBN')
            ->join('prestiti', 'copie.id_libro', 'prestiti.libro')
            ->where('user', Auth()->id())
            ->get();

        return view('auth.profile.index')
            ->with('prestiti', $prestiti)
            ->with('restituzione', false);
    }

    public function add_user($nome, $cognome, $email, $dipartimento) {

        $userr = User::where('email', $email)->first();
        if($userr == null) {
            $user = User::create([
                "name" => $nome,
                "surname" => $cognome,
                "email" => $email,
                "class" => $dipartimento
            ]);
            return $user->email;
        }
        return "no";

    }

    public function preferiti() {

        $preferiti = Libro::where('libri.ISBN', '>', 0)
            ->join('copie', 'copie.ISBN', 'libri.ISBN')
            ->join('preferiti', 'copie.ISBN', 'preferiti.ISBN')
            ->where('id_user', Auth()->id())
            ->groupBy('copie.ISBN')
            ->get();

        return view('auth.profile.preferiti')
            ->with('preferiti', $preferiti);
    }

    public function restituiti() {

        $prestiti = Libro::where('libri.ISBN', '>', 0)
            ->join('copie', 'copie.ISBN', 'libri.ISBN')
            ->join('prestiti', 'copie.id_libro', 'prestiti.libro')
            ->whereNotNull('prestiti.data_restituzione')
            ->where('user', Auth()->id())
            ->get();

        return view('auth.profile.index')
            ->with('prestiti', $prestiti)
            ->with('restituzione', true);
    }

    public function prenotati() {

        $prestiti = Libro::where('libri.ISBN', '>', 0)
            ->join('copie', 'copie.ISBN', 'libri.ISBN')
            ->join('prenotazioni', 'copie.id_libro', 'prenotazioni.id_copia')
            ->where('user', Auth()->id())
            ->get();

        return view('auth.profile.prenotazioni')
            ->with('prestiti', $prestiti);
    }

    public function generate() {

        $fileName = 'prestiti-'.Auth()->user()->class.'-'.str_replace(' ', '-', Auth()->user()->surname).'-'.str_replace(' ', '-', Auth()->user()->name).'.csv';

        $prestiti = Copia::where('copie.ISBN', '>', 0)
            ->join('libri', 'libri.ISBN', 'copie.ISBN')
            ->join('prestiti', 'copie.id_libro', 'prestiti.libro')
            ->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        return response()->stream(Libro::generate($fileName, $prestiti), 200, $headers);

    }
}
