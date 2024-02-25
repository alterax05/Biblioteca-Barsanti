<?php

namespace App\Http\Controllers;

use App\Models\Autore;
use App\Models\Editore;
use App\Models\Genere;
use App\Models\Libro;
use App\Models\Preferiti;
use App\Models\Proposta;
use App\Models\Tracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Reparto;

class IndexController extends Controller
{
    public function index() {

        if($_SERVER['REMOTE_ADDR'] != '127.0.0.1'){
            Tracker::hit();
        }


        $autori_bacheca = Autore::selectRaw('autori.id_autore, autori.autore, autori_bacheca.subtitle, schede_autori.location')
            ->join('autori_bacheca', 'autori.id_autore', 'autori_bacheca.id_autore')
            ->join('schede_autori', 'schede_autori.id_autore', 'autori_bacheca.id_autore')
            ->get(); 

            
        foreach($autori_bacheca as $autore) {
            //TODO Undefined
            $autore->libri = Autore::find($autore->id_autore)
                ->belongsLibri()
                ->orderByDesc('anno_stampa')
                ->take(4)
                ->get();
        }

        $reparti = Reparto::select(['id_reparto', 'reparto', 'icon'])
                    ->selectRaw('(SELECT COUNT(*) FROM libri WHERE libri.reparto = reparti.id_reparto GROUP BY libri.reparto) as numeri')
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
                        $libro->belongsGeneri()->attach($genere->id_genere);
                    }
            }
        }

        foreach($authors as $author) {
            $autore = Autore::firstOrCreate(['autore' => $author]);

            $libro->belongsAutori()->attach($autore->id_autore);
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

        $autori = Autore::where('autore', 'LIKE', $lettera . '%')
            ->SelectRaw('id_autore, autore, (SELECT COUNT(*) FROM libri_autori WHERE libri_autori.id_autore = autori.id_autore) AS libri')
            ->orderBy('autore')
            ->get();
        
        return view('autori')
            ->with('lettera', $lettera)
            //Divide the array in 3 parts to display them in 3 columns
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
                $preferiti->delete();
        }
        return back();
    }

    //Divide an array in $p parts
    function partition(array $list, int $p ) {
        $listlen = count( $list );
        $partlen = intval(floor( $listlen / $p ));
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
