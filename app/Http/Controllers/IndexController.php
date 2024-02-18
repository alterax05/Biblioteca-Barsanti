<?php

namespace App\Http\Controllers;

use App\Models\Autore;
use App\Models\DaFare;
use App\Models\Editore;
use App\Models\Genere;
use App\Models\Libri_Autori;
use App\Models\Libri_Generi;
use App\Models\Libro;
use App\Models\Preferiti;
use App\Models\Proposta;
use App\Models\Scheda_Autore;
use App\Models\Tracker;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Reparto;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function index() {

        Tracker::hit();

        $autori_bacheca = DB::table('autori_bacheca')
            ->join('autori', 'autori.id_autore', 'autori_bacheca.id_autore')
            ->leftJoin('schede_autori', 'schede_autori.id_autore', 'autori_bacheca.id_autore')
            ->orderByDesc('created_at')
            ->get();

        foreach($autori_bacheca as $autore) {
            $autore->libri = Libri_Autori::where('libri_autori.id_autore', $autore->id_autore)
                ->join('autori', 'autori.id_autore', 'libri_autori.id_autore')
                ->join('libri', 'libri.ISBN', 'libri_autori.ISBN')
                ->orderByDesc('libri.anno_stampa')
                ->limit(4)
                ->get();
        }

        $reparti = Reparto::where('id_reparto', '>', 0)
            ->selectRaw('reparti.id_reparto,
            reparti.reparto,
            reparti.icon,
            (SELECT COUNT(*) FROM libri WHERE libri.reparto = reparti.id_reparto GROUP BY libri.reparto) numeri')
            ->orderByDesc('numeri')
            ->get();

        $carousel = DB::table('carousel')->get();

        return view('index')
            ->with('carousel', $carousel)
            ->with('reparti', $reparti)
            ->with("autori_bacheca", $autori_bacheca);
    }

    public function nazioni() {
        $nazioni = DB::table('nazioni')->get();
        return view('nazioni')
            ->with('nazioni', $nazioni);
    }

    public function faq() {
        return view('faq');
    }

    public function proponi() {

        $proposte = Libro::where('libri.ISBN', '>', 0)
            ->leftJoin('proposte', 'libri.ISBN', 'proposte.ISBN')
            ->where('proposte.user', Auth::id())
            ->selectRaw("*, (SELECT COUNT(ISBN) FROM proposte WHERE proposte.ISBN = libri.ISBN) proposte")
            ->orderByDesc('proposte')
            ->get();

        return view('proponi')
            ->with('proposte', $proposte);
    }

    public function proponiPost(Request $request) {

        $this->validate($request, [
            'isbn' => 'required',
        ]);

        $ISBN = $request->input('isbn');
        $authors = [];

        $prop = Proposta::where('user', Auth::id())->where('ISBN', $ISBN)->first();
        if($prop != null) {
            return redirect('/proponi')->withErrors(['ISBN' => 'error']);
        }

        $libro = Libro::where('ISBN', $ISBN)->first();

        if($libro == null) {
            $detailsBasic = json_decode(file_get_contents('https://www.googleapis.com/books/v1/volumes?q=isbn:' . $ISBN), true);
            if (in_array("items", array_keys($detailsBasic))) {

                $details = json_decode(file_get_contents($detailsBasic['items'][0]['selfLink']), true);

                $editore = Editore::firstOrCreate([
                    'editore' => $details['volumeInfo']['publisher']
                ]);

                $ISBN = $details['volumeInfo']['industryIdentifiers'][1]['identifier'];

                $libro = Libro::create([
                    'ISBN' => $ISBN,
                    'titolo' => $details['volumeInfo']['title'],
                    'descrizione' => $details['volumeInfo']['description'] ?? "",
                    'editore' => $editore->id_editore,
                    'anno_stampa' => explode('-', $details['volumeInfo']['publishedDate'])[0],
                    'pagine' => $details['volumeInfo']['pageCount'] ?? 0,
                    'altezza' => $details['volumeInfo']['dimensions']['height'] ?? "",
                    'lingua' => $details['volumeInfo']['language'],
                    'reparto' => '1'
                ]);

                if (in_array('authors', array_keys($details['volumeInfo']))) {
                    foreach ($details['volumeInfo']['authors'] as $author) {
                        $authors[] = str_replace('.', '', $author);
                    }
                }

                if (in_array('categories', array_keys($details['volumeInfo'])))
                    foreach ($details['volumeInfo']['categories'] as $category) {

                        $genere = Genere::firstOrCreate(['genere' => $category]);
                        Libri_Generi::create([
                            'ISBN' => $ISBN,
                            'id_genere' => $genere->id_genere
                        ]);

                    }
            }
        }

        foreach($authors as $author) {
            $autore = Autore::firstOrCreate(['autore' => $author]);

            Libri_Autori::create([
                'id_autore' => $autore->id_autore,
                'ISBN' => $ISBN
            ]);
        }

        Proposta::create([
            'ISBN' => $ISBN,
            'user' => Auth::id(),
            'status' => 0
        ]);

        return redirect('/proponi');

    }

    public function autori($lettera) {
        $lettere = ['A','B','C','D','E','F','G','H','I','K','J','L','M','N','O','P','Q','R','S','T','U','V','Z'];

        $autori = Libri_Autori::where('libri_autori.id_autore', '>', 0)
            ->join('autori', 'autori.id_autore', 'libri_autori.id_autore')
            ->whereRaw("autori.autore LIKE '" . $lettera . "%'")
            ->selectRaw('libri_autori.id_autore, autori.autore, COUNT(libri_autori.id_autore) AS libri')
            ->groupBy('libri_autori.id_autore')
            ->orderBy('autori.autore')
            ->get();

        return view('autori')
            ->with('lettera', $lettera)
            ->with('autori', $this->partition($autori->toArray(), 3))
            ->with('lettere', $lettere);
    }

    public function preferiti($ISBN) {

        $libro = Libro::find($ISBN);
        if($libro != null) {

            $preferiti = Preferiti::where('id_user', Auth::id())->where('ISBN', $libro->ISBN);

            if($preferiti->first() == null)
                Preferiti::create([
                    'id_user' => Auth::user()->getAuthIdentifier(),
                    'ISBN' => $libro->ISBN
                ]);
            else
                $preferiti->delete([]);
        }
        return back();
    }

    function partition( $list, $p ) {
        $listlen = count( $list );
        $partlen = floor( $listlen / $p );
        $partrem = $listlen % $p;
        $partition = array();
        $mark = 0;
        for ($px = 0; $px < $p; $px++) {
            $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
            $partition[$px] = array_slice( $list, $mark, $incr );
            $mark += $incr;
        }
        return $partition;
    }

    public function lettore() {
        return view('lettore');
    }

    public function mappa() {
        return view('mappa');
    }
}
