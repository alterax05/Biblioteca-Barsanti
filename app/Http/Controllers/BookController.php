<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Copia;
use App\Models\Editore;
use App\Models\Genere;
use App\Models\Lingua;
use App\Models\Preferiti;
use App\Models\Reparto;
use App\Models\Libri_Autori;
use App\Models\Libri_Generi;
use App\Models\Scheda_Autore;
use App\Models\Autore;
use App\Models\Condizioni;
use App\Models\Prestito;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nadar\Stemming\Stemm;
use StopWords\StopWords;

class BookController extends Controller
{

    public function single($id_book) {
        $libro = Libro::where('ISBN', $id_book)
            ->first();
        $copie = Copia::where('ISBN', $id_book)
            ->join('condizioni', 'condizioni.id_condizioni', 'copie.condizioni')
            ->selectRaw('*,
            (SELECT COUNT(*) FROM prestiti WHERE libro = copie.id_libro AND data_restituzione IS NULL) prestiti')
            ->get();

        $punteggio  = 0;
        if(Auth::check()) {
            $punteggio = DB::table('recensioni')
                ->where('user', Auth::id())
                ->where('ISBN', $id_book)
                ->first();
        }

        $autore = Libri_Autori::where('ISBN', $id_book)->first();
        $scheda = Scheda_Autore::where('id_autore', $autore->id_autore)->first();

        if($scheda != null)
            $libri = Libri_Autori::where('libri_autori.id_autore', $autore->id_autore)
                ->join('libri', 'libri.ISBN', 'libri_autori.ISBN')
                ->orderByDesc('libri.anno_stampa')
                ->limit(4)
                ->get();

        return view('book.book')
            ->with('copie', $copie)
            ->with('punteggio', ($punteggio == null)? 0 : $punteggio->punteggio)
            ->with("libro", $libro)
            ->with('scheda', $scheda??null)
            ->with('libri', $libri??null)
            ->with('autore', $autore);
    }

    public function nazioni($nazione) {
        return view('book.index')->with('nazione', $nazione);
    }

    public function sezione($sezione) {
        return view('book.index')->with('sezione', $sezione);
    }

    public function autore($autore) {
        return view('book.index')->with('author', $autore);
    }

    public function index() {
        return view('book.index');
    }
}
