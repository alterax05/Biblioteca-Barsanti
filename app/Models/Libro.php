<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Libro extends Model
{

    use Searchable;

    protected $table = 'libri';
    protected $primaryKey = 'ISBN';
    protected $fillable = ['ISBN', 'titolo', 'descrizione', 'editore', 'anno_stampa', 'pagine', 'altezza', 'lingua', 'reparto'];
    public $timestamps = false;

    public function toSearchableArray()
    {
        $array = [
            'ISBN' => $this->ISBN,
            'titolo' => $this->titolo,
            'anno_stampa' => $this->anno_stampa,
            'lingua' => $this->lingua,
            'reparto' => $this->reparto];

        return $array;
    }

    public function belongsEditore() {
        return $this->belongsTo(Editore::class, 'editore');
    }

    public function belongsAutori() {
        return $this->belongsToMany(Autore::class, 'libri_autori', 'ISBN', 'id_autore');
    }

    public function belongsGeneri() {
        return $this->belongsToMany(Genere::class, 'libri_generi', 'ISBN', 'id_genere');
    }

    public function belongsLingua() {
        return $this->belongsTo(Lingua::class, 'lingua');
    }

    public function belongsReparto() {
        return $this->belongsTo(Reparto::class, 'reparto');
    }

    public static function generate($fileName, $prestiti) {

        $columns = array('Codice', 'ISBN', 'Titolo', 'Autori', 'Anno', 'Editore', 'Lingua', 'Altezza');

        $callback = function() use($prestiti, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($prestiti as $prestito) {
                $row['Codice']  = $prestito->id_libro;
                $row['ISBN']    = $prestito->ISBN;
                $row['Titolo']    = $prestito->titolo;
                $row['Autori']  = "";
                foreach($prestito->belongsAutori as $autore)
                    $row['Autori']  .= $autore->autore . ', ';

                $row['Anno']  = $prestito->anno_stampa;
                $row['Editore']  = $prestito->belongsEditore->editore;
                $row['Lingua']  = $prestito->lingua;
                $row['Altezza']  = $prestito->altezza;

                fputcsv($file, array($row['Codice'], $row['ISBN'], $row['Titolo'], $row['Autori'], $row['Anno'], $row['Editore'], $row['Lingua'], $row['Altezza']));
            }

            fclose($file);
        };

        return $callback;
    }
}
