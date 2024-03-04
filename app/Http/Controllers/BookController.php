<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Copia;
use App\Models\Scheda_Autore;
use App\Models\Autore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    public function single($id_book) {
        $libro = Libro::where('ISBN', $id_book)
            ->first();
        $copie = Copia::where('ISBN', $id_book)
            ->join('condizioni', 'condizioni.id_condizioni', 'copie.condizioni')
            ->leftJoin('prestiti', 'prestiti.id_copia', 'copie.id_copia')
            ->selectRaw('copie.*, condizioni.condizioni, (SELECT COUNT(*) FROM prestiti WHERE id_copia = copie.id_copia AND data_fine IS NULL) prestiti')
            ->whereNull('prestiti.id_copia')
            ->get();

        $punteggio  = 0;
        if(Auth::check()) {
            $punteggio = DB::table('recensioni')
                ->where('user', Auth::id())
                ->where('ISBN', $id_book)
                ->first();
        }


        $autore = Libro::find($id_book)->belongsAutori()->first();
        $scheda = Scheda_Autore::where('id_autore', $autore->id_autore)->first();

        if($scheda != null)
            $libri = Autore::find($autore->id_autore)
                ->belongsLibri()
                ->orderByDesc('anno_stampa')
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
