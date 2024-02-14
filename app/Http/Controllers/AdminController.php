<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Autori_Bacheca;
use App\Models\DaFare;
use App\Models\Prenotazione;
use App\Models\Prestito;
use App\Models\Reparto;
use App\Models\Tracker;
use App\Models\User;
use DOMDocument;
use DOMXPath;
use Exception;
use Illuminate\Http\Request;

use App\Models\Editore;
use App\Models\Libro;
use App\Models\Copia;
use App\Models\Libri_Autori;
use App\Models\Libri_Generi;
use App\Models\Genere;
use App\Models\Condizioni;
use App\Models\Autore;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $trackers = Tracker::whereRaw("visit_date = CURRENT_DATE AND NOT ip = '127.0.0.1'")
            ->get();
        return view('admin.index')->with('trackers', $trackers);
    }

    public function book($ISBN, $codice) {

        $libro = Copia::where('id_libro', $codice)
            ->join('libri', 'libri.ISBN', 'copie.ISBN')
            ->where('copie.ISBN', $ISBN)
            ->first();

        $autori = Libri_Autori::where('libri_autori.ISBN', $libro->ISBN)
            ->join('autori', 'autori.id_autore', 'libri_autori.id_autore')
            ->get();

        $autoriAll = Autore::where('id_autore', '>', 0)->orderBy('autore')->get();

        return view('admin.book')
            ->with('autori', $autori)
            ->with('autoriAll', $autoriAll)
            ->with('libro', $libro);
    }

    public function prestiti() {
        $prestiti = Libro::where('libri.ISBN', '>', 0)
            ->leftJoin('copie', 'libri.ISBN', 'copie.ISBN')
            ->rightJoin('prestiti', 'prestiti.libro', 'copie.id_libro')
            ->join('users', 'users.id', 'prestiti.user')
            ->whereNull('prestiti.data_restituzione')
            ->orderByDesc('prestiti.data_prestito')
            ->get();
        return view('admin.prestiti')
            ->with('prestiti', $prestiti);
    }

    public function prenota() {
        $prestiti = Libro::where('libri.ISBN', '>', 0)
            ->leftJoin('copie', 'libri.ISBN', 'copie.ISBN')
            ->rightJoin('prenotazioni', 'prenotazioni.id_copia', 'copie.id_libro')
            ->join('users', 'users.id', 'prenotazioni.user')
            ->orderByDesc('prenotazioni.created_at')
            ->get();
        return view('admin.prenota')
            ->with('prestiti', $prestiti);
    }

    public function presta() {
        return view('admin.presta');
    }

    public function prestaPost(Request $request) {

        $this->validate($request, [
            'ISBN' => 'required',
            'copia' => 'required',
            'user' => 'required|int'
        ]);

        $user = User::where('id', $request->input('user'))->first();

        Prestito::create([
            'libro' => $request->input('copia'),
            'user' => $user->id,
            'ISBN' => $request->input('ISBN')
        ]);

        Prenotazione::where('user', $user->id)->where('id_copia', $request->input('copia'))->delete();

        return view('admin.presta');
    }

    public function completi() {

        $libri = Copia::where('copie.ISBN', '>', 0)
            ->join('libri', 'copie.ISBN', 'libri.ISBN')
            ->selectRaw('libri.ISBN, libri.titolo, copie.id_libro')
            ->whereRaw('(select COUNT(*) from libri_autori where libri_autori.ISBN = copie.ISBN) = 0 or copie.id_libro < 100')->get();

        return view('admin.completi')
            ->with('libri', $libri);
    }

    public function generate() {

        $fileName = 'libri'.date('-d-M-Y--H-i-s').'.csv';

        $prestiti = Copia::where('libri.ISBN', '>', 0)
            ->join('libri', 'libri.ISBN', 'copie.ISBN')
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

    public function authors(Request $request, $ISBN) {
        $this->validate($request, [
            'author' => 'required'
        ]);

        Libri_Autori::create([
            'id_autore' => $request->input('author'),
            'ISBN' => $ISBN
        ]);

        return back();
    }

    public function insertGet() {
        $condizioni = Condizioni::where('id_condizioni', '>', '0')
            ->orderBy('id_condizioni')
            ->get();

        $da_fare = DaFare::where('id_libro', '>', '0')->orderByDesc('id_Libro')->get();
        $reparti = Reparto::all();

        return view('admin.insert')
            ->with('dafare', $da_fare)
            ->with('reparti', $reparti)
            ->with('condizioni', $condizioni);
    }

    public function indexAdvanced() {
        $condizioni = Condizioni::where('id_condizioni', '>', '0')
            ->orderBy('id_condizioni')
            ->get();

        $generi = Genere::all();
        $editori = Editore::all();
        $reparti = Reparto::all();

        return view('admin.insertAdvanced')
            ->with('generi', $generi)
            ->with('editori', $editori)
            ->with('reparti', $reparti)
            ->with('condizioni', $condizioni);
    }

    public function advancedPost(Request $request) {

        $this->validate($request, [
            'titolo' => 'required',
            'id_libro' => 'required',
            'autore' => 'required',
            'genere' => 'required',
            'editore' => 'required',
            'condizioni' => 'required',
            'lingua' => 'required',
            'anno' => 'required',
            'scaffale' => 'required|string',
            'ripiano' => 'required|int|max:20',
            'prestati' => 'required|int',
            'reparto' => 'required|int',
        ]);

        $random = rand(1000000000000, 9999999999999);
        $libroX = Libro::where('ISBN', $random)->first();
        while($libroX != null) {
            $random = rand(1000000000000, 9999999999999);
            $libroX = Libro::where('ISBN', $random)->first();
        }

        try {
            Libro::create([
                'ISBN' => $random,
                'titolo' => $request->input('titolo'),
                'editore' => $request->input('editore'),
                'anno_stampa' => $request->input('anno'),
                'pagine' => 0,
                'altezza' => "",
                'lingua' => $request->input('lingua'),
                'reparto' => $request->input('reparto')
            ]);
        }catch(Exception $e) {
            return redirect('/admin/insert/advanced')->withErrors(['anno_stampa' => 'L\'anno dev\'essere con 4 cifre']);
        }

        try {
            Copia::create([
                'id_libro' => $request->input('id_libro'),
                'ISBN' => $random,
                'scaffale' => $request->input('scaffale'),
                'ripiano' => $request->input('ripiano'),
                'prestati' => $request->input('prestati'),
                'condizioni' => $request->input('condizioni'),
            ]);
        }catch(Exception $e) {
            return redirect('/admin/insert/advanced')->withInput()->withErrors([
                'scaffale' => 'Forse lo scaffale è errato (es. 15A)',
                'ripiano' => 'Forse il ripiano è errato (es. 1)',
            ]);
        }

        try {
            Libri_Generi::create([
                'ISBN' => $random,
                'id_genere' => intval($request->input('genere'))
            ]);

            $autore = Autore::firstOrCreate(['autore' => $request->input('autore')]);
            Libri_Autori::create([
                'id_autore' => intval($autore->id_autore),
                'ISBN' => $random
            ]);
        }catch(Exception $e) {
            return redirect('/admin/insert/advanced')->withInput();
        }

        return redirect('/admin/insert/advanced/?scaffale='.$request->input('scaffale') . '&ripiano='.$request->input('ripiano'));
    }


    public function insert(Request $request) {

        $this->validate($request, [
            'isbn' => 'required',
            'scaffale' => 'required|string',
            'ripiano' => 'required|int|max:20',
            'codice' => 'required|int',
            'prestati' => 'required|int',
            'reparto' => 'required|int',
        ]);


        $daf = DaFare::where('ISBN', $request->input('isbn'))->first();
        if($daf != null)
            DaFare::where('id_libro', $daf->id_libro)->delete();

        $this->saveBook($request->input('codice'),
            $request->input('isbn'),
            $request->input('scaffale'),
            $request->input('ripiano'),
            $request->input('condizioni'),
            $request->input('reparto'),
            $request->input('prestati'));

        return redirect('/admin/insert/?scaffale='.$request->input('scaffale') . '&ripiano='.$request->input('ripiano'));
    }

    public function insertPost(Request $request, $ISBN) {

        $editore = Editore::firstOrCreate([
            'editore' => $request->input('editore')
        ]);

        $libro = Libro::create([
            'ISBN' => $ISBN,
            'titolo' => $request->input('titolo'),
            'descrizione' => $request->input('descrizione'),
            'editore' => $editore->id_editore,
            'anno_stampa' => explode('-', $request->input('anno_stampa'))[0],
            'pagine' => $request->input('pagine') ?? 0,
            'altezza' => $request->input('altezza') ?? "",
            'lingua' => $request->input('lingua'),
        ]);

        return $libro->titolo . " salvato!";
    }

    public function insertApp($ISBN) {
        DaFare::create(['ISBN' => $ISBN]);
        return "Done";
    }

    function saveBook($id, $ISBN, $scaffale, $ripiano, $condizioni, $reparto, $prestati = 0) {
        $libro = Libro::where('ISBN', $ISBN)->first();
        $authors = [];

        if($libro == null) {
            $detailsBasic = json_decode(file_get_contents('https://www.googleapis.com/books/v1/volumes?q=isbn:' . $ISBN), true);
            if(in_array("items", array_keys($detailsBasic))) {

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
                    'reparto' => $reparto
                ]);

                if(in_array('authors', array_keys($details['volumeInfo']))) {
                    foreach ($details['volumeInfo']['authors'] as $author) {
                        array_push($authors, str_replace('.', '', $author));
                    }
                }

                $img = Image::make("https://www.ibs.it/images/".$ISBN."_0_0_536_0_75.jpg");
                $img->resize(136, 209, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save(public_path('imgs/covers/' . $ISBN . ".jpg"));


                if(in_array('categories', array_keys($details['volumeInfo'])))
                    foreach ($details['volumeInfo']['categories'] as $category) {

                        $genere = Genere::firstOrCreate(['genere' => $category]);
                        Libri_Generi::create([
                            'ISBN' => $ISBN,
                            'id_genere' => $genere->id_genere
                        ]);

                    }

            }else{
                libxml_use_internal_errors(true);
                $doc = new DOMDocument;
                $doc->loadhtmlfile("https://www.bookfinder.com/search/isbn/?author=&title=&lang=it&isbn=".$ISBN."&new_used=*&destination=it&currency=EUR&mode=basic&st=sr&ac=qr&ps=bp");
                libxml_use_internal_errors(false);

                $xpath = new DOMXpath($doc);

                $author = "";
                $review = $xpath->query("//span[@itemprop='author']");
                if($review->length > 0)
                    $author = $review->item(0)->nodeValue;

                $author = explode(', ', explode('; ', $author)[0]);

                $anno = ", 2000";
                $review = $xpath->query("//span[@itemprop='publisher']");
                if($review->length > 0)
                    $anno = $review->item(0)->nodeValue;

                $libro = Libro::create([
                    'ISBN' => $ISBN,
                    'titolo' => strip_tags($doc->getElementById('describe-isbn-title')->textContent),
                    'pagine' => 0,
                    'anno_stampa' => explode(', ', $anno)[1],
                    'lingua' => "it",
                ]);

                $possibleAuthor = $author[1] ?? "" ." ".$author[0];
                if($possibleAuthor != " ") {
                    array_push($authors, $possibleAuthor);
                }
            }
        }

        if(true) {
            $copia = Copia::create([
                'id_libro' => $id,
                'ISBN' => $ISBN,
                'scaffale' => $scaffale,
                'ripiano' => $ripiano,
                'prestati' => $prestati,
                'condizioni' => $condizioni,
            ]);
        }

        if(true) {
            foreach($authors as $author) {
                $autore = Autore::firstOrCreate(['autore' => $author]);

                Libri_Autori::create([
                    'id_autore' => $autore->id_autore,
                    'ISBN' => $ISBN
                ]);
            }
        }

        return '';
    }

    public function restituisci(Request $request) {

        $this->validate($request, [
            'libro' => 'required',
        ]);

        $libro = Prestito::where('prestiti.libro', $request->input('libro'))
            ->whereNull('prestiti.data_restituzione')
            ->first();

        if($libro != null) {
            $libro->data_restituzione = now();
            $libro->save();
        }else{
            return redirect()->back()->withErrors(['libro' => 'Libro non trovato.']);
        }

        return redirect()->back();
    }

    public function proposte() {
        $proposte = Libro::where('libri.ISBN', '>', 0)
            ->leftJoin('proposte', 'libri.ISBN', 'proposte.ISBN')
            ->where('proposte.user', '>', 0)
            ->selectRaw("*, (SELECT COUNT(ISBN) FROM proposte WHERE proposte.ISBN = libri.ISBN) proposte")
            ->groupBy('libri.ISBN')
            ->orderByDesc('proposte')
            ->get();

        return view('admin.proposte')
            ->with('proposte', $proposte);
    }

    public function bacheca() {
        $autori_bacheca = Autori_Bacheca::join('autori', 'autori.id_autore', '=', 'autori_bacheca.id_autore')
        ->leftJoin('schede_autori', 'schede_autori.id_autore', '=', 'autori_bacheca.id_autore')
        ->select(
            'autori_bacheca.id_autore',
            'autori_bacheca.subtitle',
            'autori.autore',
            'schede_autori.location',
            'schede_autori.id_nazione',
            'schede_autori.anno_nascita',
            'schede_autori.anno_morte',
            'schede_autori.avatar'
        )
        ->get();

        $autori = Autore::all();
        return view('admin.bacheca')
            ->with('autori', $autori)
            ->with('autori_bacheca', $autori_bacheca);
    }

    public function bachecaAdd(Request $request) {

        $this->validate($request, [
            'autore' => 'required|int',
            'subtitle' => 'required|string'
        ]);

        $autore = Autori_Bacheca::create([
            'id_autore' => $request->input('autore'),
            'subtitle' => $request->input('subtitle')
        ]);

        return redirect()->back();
    }

    public function bachecaDelete($id_autore) {

        $autore = Autori_Bacheca::where('id_autore', $id_autore)->first();

        if($autore != null)
            $autore->delete();

        return redirect()->back();
    }
}
