<?php

namespace App\Http\Controllers;

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
use App\Models\Genere;
use App\Models\Condizioni;
use App\Models\Autore;


class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard with the current day's visitors.
     */
    public function index() {
        $trackers = Tracker::where('visit_date', date('Y-m-d'))
            ->whereNot('ip', '=', '127.0.0.1')
            ->get();
        return view('admin.index')->with('trackers', $trackers);
    }

    public function book($ISBN, $codice) {

        $libro = Copia::where('num_copia', $codice)
            ->join('libri', 'libri.ISBN', 'copie.ISBN')
            ->where('copie.ISBN', $ISBN)
            ->first();

        $autori = Libro::find($ISBN)->belongsAutori()->get();

        $autoriAll = Autore::orderBy('autore')->get();

        return view('admin.book')
            ->with('autori', $autori)
            ->with('autoriAll', $autoriAll)
            ->with('libro', $libro);
    }

    public function prestiti() {
        $prestiti = Libro::select()
            ->leftJoin('copie', 'libri.ISBN', 'copie.ISBN')
            ->rightJoin('prestiti', 'prestiti.id_copia', 'copie.id_copia')
            ->join('users', 'users.id', 'prestiti.id_user')
            ->whereNull('prestiti.data_fine')
            ->orderByDesc('prestiti.data_inizio')
            ->get();
        return view('admin.prestiti')
            ->with('prestiti', $prestiti);
    }

    public function prenota() {
        $prestiti = Libro::where('libri.ISBN', '>', 0)
            ->leftJoin('copie', 'libri.ISBN', 'copie.ISBN')
            ->rightJoin('prenotazioni', 'prenotazioni.id_copia', 'copie.id_copia')
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
            'id_copia' => $request->input('copia'),
            'id_user' => $user->id,
        ]);

        Prenotazione::where('user', $user->id)->where('id_copia', $request->input('copia'))->delete();

        return view('admin.presta');
    }

    public function completi() {

        $libri = Copia::select(["libri.*", "copie.da_catalogare", "copie.num_copia"])
            ->join('libri', 'copie.ISBN', 'libri.ISBN')
            ->leftJoin('libri_autori', 'libri.ISBN', 'libri_autori.ISBN')
            ->whereNull('libri_autori.ISBN')
            ->orWhere('copie.da_catalogare', 1)
            ->get();
        

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
        return response()->download(Libro::generate($fileName, $prestiti), $headers);
    }

    public function authors(Request $request, $ISBN) {
        $this->validate($request, [
            'author' => 'required'
        ]);

        Libro::find($ISBN)->belongsAutori()->attach($request->input('author'));

        return back();
    }

    public function insertGet() {
        $condizioni = Condizioni::select()
            ->orderBy('id_condizioni')
            ->get();

        $da_fare = DaFare::select()->orderByDesc('id_copia')->get();
        $reparti = Reparto::all();

        return view('admin.insert')
            ->with('dafare', $da_fare)
            ->with('reparti', $reparti)
            ->with('condizioni', $condizioni);
    }

    public function indexAdvanced() {
        $condizioni = Condizioni::select()
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
            $libro = Libro::create([
                'ISBN' => $random,
                'titolo' => $request->input('titolo'),
                'editore' => $request->input('editore'),
                'anno_stampa' => $request->input('anno'),
                'pagine' => 0,
                'altezza' => "",
                'lingua' => $request->input('lingua'),
                'reparto' => $request->input('reparto'),
                'descrizione' => ''
            ]);
        }catch(Exception $e) {
            return redirect('/admin/insert/advanced')->withErrors(['anno_stampa' => 'L\'anno dev\'essere con 4 cifre']);
        }

        try {
            Copia::create([
                'num_copia' => $request->input('id_libro'),
                'ISBN' => $random,
                'scaffale' => $request->input('scaffale'),
                'ripiano' => $request->input('ripiano'),
                'prestati' => $request->input('prestati'),
                'condizioni' => $request->input('condizioni'),
                'da_catalogare' => 1
            ]);
        }catch(Exception $e) {
            return redirect('/admin/insert/advanced')->withInput()->withErrors([
                'scaffale' => 'Forse lo scaffale è errato (es. 15A)',
                'ripiano' => 'Forse il ripiano è errato (es. 1)',
            ]);
        }

        try {
            $autore = Autore::firstOrCreate(['autore' => $request->input('autore')]);
            $libro->belongsAutori()->attach($autore->id_autore);
            $genere = Genere::firstOrCreate(['genere' => $request->input('genere')]);
            $libro->belongsGeneri()->attach($genere->id_genere);
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
            DaFare::where('id_copia', $daf->id_copia)->delete();

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


                if(in_array('categories', array_keys($details['volumeInfo'])))
                    foreach ($details['volumeInfo']['categories'] as $category) {
                        $genere = Genere::firstOrCreate(['genere' => $category]);
                        $libro->belongsGeneri()->attach($genere->id_genere);
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

        Copia::create([
            'num_copia' => $id,
            'ISBN' => $ISBN,
            'scaffale' => $scaffale,
            'ripiano' => $ripiano,
            'prestati' => $prestati,
            'condizioni' => $condizioni,
        ]);

        foreach($authors as $author) {
            $autore = Autore::firstOrCreate(['autore' => $author]);

            $libro->belongsAutori()->attach($autore->id_autore);
        }
    }

    public function restituisci(Request $request) {

        $this->validate($request, [
            'libro' => 'required',
        ]);

        $prestito = Prestito::where('id_copia', $request->input('libro'))
            ->whereNull('prestiti.data_fine')
            ->first();

        if($prestito != null) {
            $prestito->data_fine = now();
            $prestito->save();
        }else{
            return redirect()->back()->withErrors(['libro' => 'Libro non trovato.']);
        }

        return redirect()->back();
    }

    public function proposte() {
        $proposte = Libro::select()
            ->distinct()
            ->join('proposte', 'libri.ISBN', 'proposte.ISBN')
            ->whereNotNull('proposte.id_user')
            ->selectRaw("(SELECT COUNT(ISBN) FROM proposte WHERE proposte.ISBN = libri.ISBN) proposte")
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
