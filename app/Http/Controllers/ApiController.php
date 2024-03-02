<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Copia;
use App\Models\Editore;
use App\Models\Condizioni;
use App\Models\Lingua;
use App\Models\Genere;
use App\Models\Autore;
use App\Models\Preferiti;
use App\Models\Prenotazione;
use App\Models\Prestito;
use App\Models\Recensione;
use App\Models\Scheda_Autore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function searchSuggestions($query)
    {

        $libri = Libro::search($query)
            ->query(function ($builder) {
                return $builder->select(["ISBN as id", "titolo as query"])
                    ->selectRaw("'book' as type")
                    ->limit(5);
            })
            ->get()
            ->toArray();


        $autori = Autore::search($query)
            ->query(function ($builder) {
                return $builder->select(["id_autore as id", "autore as query"])
                    ->selectRaw("'author' as type")
                    ->limit(5);
            })
            ->get()
            ->toArray();


        $result = $libri + $autori;

        foreach ($result as $res) {
            if (strlen($res['query']) > 80) {
                $res['query'] = explode('.', $res['query'])[0];
            }
        }

        return response()->json($result, 201);
    }

    public function adminSearch($ISBN)
    {
        $libro = Libro::where('libri.ISBN', $ISBN)
            ->join('editori', 'editori.id_editore', 'libri.editore')
            ->first();

        if ($libro == null)
            return response()->json(['error' => 'Libro non trovato'], 404);

        $libro->copie = Copia::where('copie.ISBN', $ISBN)
            ->whereRaw("(SELECT COUNT(*) FROM prestiti WHERE prestiti.id_copia = copie.id_copia) < 1")
            ->get();


        foreach ($libro->copie as $copia) {
            $copia->prenotato = Prenotazione::where('id_copia', $copia->id_copia)
                ->join('users', 'prenotazioni.user', 'users.id')
                ->get();
        }

        return response()->json($libro);
    }

    public function restituisci($ISBN)
    {

        $libro = Prestito::where('copie.ISBN', $ISBN)
            ->selectRaw('libri.titolo, copie.num_copia, CONCAT(users.name, " ", users.surname) as utente, copie.id_copia')
            ->join('copie', 'copie.id_copia', 'prestiti.id_copia')
            ->join('libri', 'libri.ISBN', '=', 'copie.ISBN')
            ->join('users', 'users.id', '=', 'prestiti.id_user')
            ->whereNull('prestiti.data_fine')
            ->get();

        return response()->json($libro);
    }

    public function condizioni()
    {
        return response()->json(Condizioni::all());
    }

    public function autori($query)
    {
        $autori = Autore::search($query)
            ->query(function ($builder) {
                return $builder->select(["autore"])
                    ->limit(20);
            })
            ->get();
        return response()->json($autori);
    }

    public function recensioni(Request $request)
    {
        $this->validate($request, [
            'ISBN' => 'required',
            'punteggio' => 'required|int',
        ]);

        $rec = Recensione::where('ISBN', $request->input('ISBN'))->where('user', Auth::id())->first();

        if ($rec == null) {
            $rec = Recensione::create([
                'ISBN' => $request->input('ISBN'),
                'user' => Auth::id(),
                'punteggio' => $request->input('punteggio'),
            ]);
        } else {
            $rec->punteggio = $request->input('punteggio');
            $rec->save();
        }

        return "Recensione salvata!";
    }

    public function prenotazione(Request $request)
    {

        $this->validate($request, [
            'id_copia' => 'required|int',
        ]);

        $pren = Prenotazione::where('id_copia', $request->input('id_copia'))->first();

        if ($pren == null) {
            $pren = Prenotazione::create([
                'id_copia' => $request->input('id_copia'),
                'user' => Auth::id(),
            ]);
        } else {
            return "Copia non disponibile, riprovare!";
        }
        return "Prenotazione salvata!";
    }

    public function get_books($page, $query, $orderby, $genere, $autore, $editore, $nazione, $sezione)
    {
        $books = Libro::query()->selectRaw('libri.ISBN, libri.titolo, libri.anno_stampa, libri.editore, libri.lingua,
        (SELECT COUNT(*) FROM copie WHERE copie.ISBN = libri.ISBN) copie,
        (SELECT COUNT(*) FROM prestiti
        INNER JOIN copie ON prestiti.id_copia = copie.id_copia
        WHERE copie.ISBN = libri.ISBN AND data_fine IS NULL) prestiti,
        (SELECT COALESCE(AVG(punteggio), 0) FROM recensioni WHERE recensioni.ISBN = libri.ISBN) media');

        if ($query != "NaN" && $query != "undefined") {

            $ids = Libro::search($query)
                ->query(function ($builder) {
                    return $builder->select(["ISBN"]);
                })
                ->get()
                ->pluck('ISBN')
                ->toArray();

            $books = $books->whereIn('libri.ISBN', $ids);
        }

        if ($editore != "0" && $editore != "undefined") {
            $books = $books->where('editore', $editore);
        }

        if ($autore != "0" && $autore != "undefined") {
            $ids = Autore::find($autore)
                ->belongsLibri()
                ->select("libri.ISBN")
                ->get()
                ->pluck("ISBN")
                ->toArray();

            $books = $books->whereIn('libri.ISBN', $ids);
        } else {
            if ($query != "NaN" && $query != "undefined") {
                $ids = Autore::search($query)
                    ->query(function ($builder) {
                        return $builder->with('libri');  // Assumendo che 'libri' sia il nome della relazione
                    })
                    ->get()
                    ->flatMap(function ($autore) {
                        return $autore->belongsLibri->pluck('ISBN');
                    })
                    ->toArray();
                
                if(count($ids) > 0)
                    $books = $books->whereIn('libri.ISBN', $ids);
            }
        }

        if ($genere != "0" && $genere != "undefined") {

            $ids = Genere::find($genere)
                ->belongsLibri()
                ->select("libri.ISBN")
                ->get()
                ->pluck("ISBN")
                ->toArray();

            $books = $books->whereIn('libri.ISBN', $ids);
        }

        if ($sezione != "0" && $sezione != "undefined") {
            $books = $books->where('reparto', $sezione);
        }

        if ($nazione != "0" && $nazione != "undefined") {
            $ids = Scheda_Autore::where('id_nazione', $nazione)
                ->join('libri_autori', 'libri_autori.id_autore', 'schede_autori.id_autore')
                ->select('ISBN')->get();
            $books = $books->whereIn('libri.ISBN', $ids);
        }


        $ids = [];
        $ISBN = $books->get();
        foreach ($ISBN as $libro) {
            $ids[] = $libro->ISBN;
        }

        $autori = $this->getAutoriFilter($ids);
        $generi = $this->getGenereFilter($ids);
        $editori = $this->getEditoriFilter($ids);
        $anni = $this->getAnniFilter($ids);
        $lingue = $this->getLingueFilter($ids);


        $count = $books->count();
        $pages = ceil($count / 10);

        $schedaAutore = null;
        if ($autore != 0 && $autore != "undefined") {
            $schedaAutore = Scheda_Autore::where('id_autore', $autore)->first();
            if ($schedaAutore != null) {
                $schedaAutore->belongsNazione;
                $schedaAutore->belongsAutore;
            }
        }

        switch ($orderby) {
            case 'annoDesc':
                $books = $books->orderByDesc('anno_stampa');
                break;
            case 'annoAsc':
                $books = $books->orderBy('anno_stampa');
                break;
            case 'titoloAsc':
                $books = $books->orderBy('titolo');
                break;
            case 'titoloDesc':
                $books = $books->orderByDesc('titolo');
                break;
            case 'copie':
                $books = $books->orderByDesc('copie');
                break;
            case 'prestati':
                $books = $books->selectRaw(' (SELECT COUNT(*) FROM prestiti INNER JOIN copie ON prestiti.id_copia = copie.id_copia WHERE copie.ISBN = copie.ISBN) +
                    (SELECT SUM(copie.prestati) FROM copie WHERE copie.ISBN = libri.ISBN GROUP BY copie.ISBN) prestitiTotali')
                    ->orderByDesc('prestitiTotali');
                break;
            default:
                $books = $books->orderByDesc('media')->orderByDesc('anno_stampa');
                break;
        }

        $books = $books->skip((intval($page) - 1) * 10)->take(10);
        $books = $books->with(['belongsAutori.belongsScheda', 'belongsGeneri', 'belongsEditore', 'belongsAutori', 'belongsAutori.belongsScheda.belongsNazione']);
        $books = $books->get();

        $preferiti = Preferiti::where('id_user', Auth::id())->pluck('ISBN')->toArray();

        foreach ($books as $book) {
            if (in_array($book->ISBN, $preferiti)) {
                $book->preferiti = 1;
            }
        }

        return response()->json([
            "elements" => $count,
            "pages" => $pages,
            "books" => $books,
            "scheda_autore" => $schedaAutore,
            "autori" => $autori,
            'editori' => $editori,
            'generi' => $generi,
            'lingue' => $lingue,
            'anni' => $anni
        ], 201);
    }

    public function barcode($libro_id)
    {
        $code_string = "";
        $filepath = "";

        $libro = Libro::find($libro_id);
        if ($libro == null)
            return redirect('/');

        $text = $libro->ISBN;
        $size = "45";
        $orientation = "horizontal";
        $code_type = "code128";
        $print = false;
        $SizeFactor = "1";

        if (in_array(strtolower($code_type), array("code128", "code128b"))) {
            $chksum = 104;

            $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "\`" => "111422", "a" => "121124", "b" => "121421", "c" => "141122", "d" => "141221", "e" => "112214", "f" => "112412", "g" => "122114", "h" => "122411", "i" => "142112", "j" => "142211", "k" => "241211", "l" => "221114", "m" => "413111", "n" => "241112", "o" => "134111", "p" => "111242", "q" => "121142", "r" => "121241", "s" => "114212", "t" => "124112", "u" => "124211", "v" => "411212", "w" => "421112", "x" => "421211", "y" => "212141", "z" => "214121", "{" => "412121", "|" => "111143", "}" => "111341", "~" => "131141", "DEL" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "FNC 4" => "114131", "CODE A" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ($X = 1; $X <= strlen($text); $X++) {
                $activeKey = substr($text, ($X - 1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum = ($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

            $code_string = "211214" . $code_string . "2331112";
        } elseif (strtolower($code_type) == "code128a") {
            $chksum = 103;
            $text = strtoupper($text); // Code 128A doesn't support lower case
            // Must not change order of array elements as the checksum depends on the array's key to validate final code
            $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "NUL" => "111422", "SOH" => "121124", "STX" => "121421", "ETX" => "141122", "EOT" => "141221", "ENQ" => "112214", "ACK" => "112412", "BEL" => "122114", "BS" => "122411", "HT" => "142112", "LF" => "142211", "VT" => "241211", "FF" => "221114", "CR" => "413111", "SO" => "241112", "SI" => "134111", "DLE" => "111242", "DC1" => "121142", "DC2" => "121241", "DC3" => "114212", "DC4" => "124112", "NAK" => "124211", "SYN" => "411212", "ETB" => "421112", "CAN" => "421211", "EM" => "212141", "SUB" => "214121", "ESC" => "412121", "FS" => "111143", "GS" => "111341", "RS" => "131141", "US" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "CODE B" => "114131", "FNC 4" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ($X = 1; $X <= strlen($text); $X++) {
                $activeKey = substr($text, ($X - 1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum = ($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

            $code_string = "211412" . $code_string . "2331112";
        } elseif (strtolower($code_type) == "code39") {
            $code_array = array("0" => "111221211", "1" => "211211112", "2" => "112211112", "3" => "212211111", "4" => "111221112", "5" => "211221111", "6" => "112221111", "7" => "111211212", "8" => "211211211", "9" => "112211211", "A" => "211112112", "B" => "112112112", "C" => "212112111", "D" => "111122112", "E" => "211122111", "F" => "112122111", "G" => "111112212", "H" => "211112211", "I" => "112112211", "J" => "111122211", "K" => "211111122", "L" => "112111122", "M" => "212111121", "N" => "111121122", "O" => "211121121", "P" => "112121121", "Q" => "111111222", "R" => "211111221", "S" => "112111221", "T" => "111121221", "U" => "221111112", "V" => "122111112", "W" => "222111111", "X" => "121121112", "Y" => "221121111", "Z" => "122121111", "-" => "121111212", "." => "221111211", " " => "122111211", "$" => "121212111", "/" => "121211121", "+" => "121112121", "%" => "111212121", "*" => "121121211");

            // Convert to uppercase
            $upper_text = strtoupper($text);

            for ($X = 1; $X <= strlen($upper_text); $X++) {
                $code_string .= $code_array[substr($upper_text, ($X - 1), 1)] . "1";
            }

            $code_string = "1211212111" . $code_string . "121121211";
        } elseif (strtolower($code_type) == "code25") {
            $code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
            $code_array2 = array("3-1-1-1-3", "1-3-1-1-3", "3-3-1-1-1", "1-1-3-1-3", "3-1-3-1-1", "1-3-3-1-1", "1-1-1-3-3", "3-1-1-3-1", "1-3-1-3-1", "1-1-3-3-1");

            for ($X = 1; $X <= strlen($text); $X++) {
                for ($Y = 0; $Y < count($code_array1); $Y++) {
                    if (substr($text, ($X - 1), 1) == $code_array1[$Y])
                        $temp[$X] = $code_array2[$Y];
                }
            }

            for ($X = 1; $X <= strlen($text); $X += 2) {
                if (isset($temp[$X]) && isset($temp[($X + 1)])) {
                    $temp1 = explode("-", $temp[$X]);
                    $temp2 = explode("-", $temp[($X + 1)]);
                    for ($Y = 0; $Y < count($temp1); $Y++)
                        $code_string .= $temp1[$Y] . $temp2[$Y];
                }
            }

            $code_string = "1111" . $code_string . "311";
        } elseif (strtolower($code_type) == "codabar") {
            $code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "-", "$", ":", "/", ".", "+", "A", "B", "C", "D");
            $code_array2 = array("1111221", "1112112", "2211111", "1121121", "2111121", "1211112", "1211211", "1221111", "2112111", "1111122", "1112211", "1122111", "2111212", "2121112", "2121211", "1121212", "1122121", "1212112", "1112122", "1112221");

            // Convert to uppercase
            $upper_text = strtoupper($text);

            for ($X = 1; $X <= strlen($upper_text); $X++) {
                for ($Y = 0; $Y < count($code_array1); $Y++) {
                    if (substr($upper_text, ($X - 1), 1) == $code_array1[$Y])
                        $code_string .= $code_array2[$Y] . "1";
                }
            }
            $code_string = "11221211" . $code_string . "1122121";
        }

        // Pad the edges of the barcode
        $code_length = 20;
        if ($print) {
            $text_height = 30;
        } else {
            $text_height = 0;
        }

        for ($i = 1; $i <= strlen($code_string); $i++) {
            $code_length = $code_length + (int)(substr($code_string, ($i - 1), 1));
        }

        if (strtolower($orientation) == "horizontal") {
            $img_width = $code_length * $SizeFactor;
            $img_height = $size;
        } else {
            $img_width = $size;
            $img_height = $code_length * $SizeFactor;
        }

        $image = imagecreate($img_width, $img_height + $text_height);
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);

        imagefill($image, 0, 0, $white);
        if ($print) {
            imagestring($image, 5, 31, $img_height, $text, $black);
        }

        $location = 10;
        for ($position = 1; $position <= strlen($code_string); $position++) {
            $cur_size = $location + (substr($code_string, ($position - 1), 1));
            if (strtolower($orientation) == "horizontal")
                imagefilledrectangle($image, $location * $SizeFactor, 0, $cur_size * $SizeFactor, $img_height, ($position % 2 == 0 ? $white : $black));
            else
                imagefilledrectangle($image, 0, $location * $SizeFactor, $img_width, $cur_size * $SizeFactor, ($position % 2 == 0 ? $white : $black));
            $location = $cur_size;
        }

        // Draw barcode to the screen or save in a file
        if ($filepath == "") {
            return response(imagepng($image))->header('Content-type', 'image/png');
        }
    }

    private function getEditoriFilter($ids)
    {
        return Libro::whereIntegerInRaw('ISBN', $ids)
            ->selectRaw('editori.id_editore, editori.editore, COUNT(*) as numero')
            ->join('editori', 'libri.editore', '=', 'editori.id_editore')
            ->groupBy('editori.id_editore', 'editori.editore')
            ->orderByDesc('numero')
            ->limit(10)
            ->get();
    }

    private function getLingueFilter($ids)
    {
        return Libro::whereIntegerInRaw('ISBN', $ids)
            ->selectRaw('lingue.tag_lingua, lingue.lingua, COUNT(*) as numero')
            ->join('lingue', 'libri.lingua', '=', 'lingue.tag_lingua')
            ->groupBy('lingue.tag_lingua', 'lingue.lingua')
            ->orderByDesc('numero')
            ->get();
    }

    private function getGenereFilter($ids)
    {
        return Genere::select(['generi.id_genere', 'generi.genere'])
            ->selectRaw('COUNT(*) as numero')
            ->join('libri_generi', 'generi.id_genere', '=', 'libri_generi.id_genere')
            ->whereIn('libri_generi.ISBN', $ids)
            ->groupBy('generi.id_genere', 'generi.genere')
            ->orderByDesc('numero')
            ->limit(10)
            ->get();
    }

    private function getAnniFilter($ids)
    {
        return Libro::whereIntegerInRaw('ISBN', $ids)
            ->selectRaw('anno_stampa, COUNT(*) as numero')
            ->groupBy('anno_stampa')
            ->orderByDesc('numero')
            ->limit(10)
            ->get();
    }

    private function getAutoriFilter($ids)
    {
        return Autore::select(['autori.id_autore', 'autori.autore'])
            ->selectRaw('COUNT(*) as numero')
            ->join('libri_autori', 'autori.id_autore', '=', 'libri_autori.id_autore')
            ->whereIn('libri_autori.ISBN', $ids)
            ->groupBy('autori.id_autore', 'autori.autore')
            ->orderByDesc('numero')
            ->limit(10)
            ->get();
    }
}
