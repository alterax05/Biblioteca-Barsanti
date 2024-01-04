<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $table = 'libri';
    protected $primaryKey = 'ISBN';
    protected $fillable = ['ISBN', 'titolo', 'descrizione', 'editore', 'anno_stampa', 'pagine', 'altezza', 'lingua', 'reparto'];
    const UPDATED_AT = null;

    public function belongsEditore() {
        return $this->belongsTo(Editore::class, 'editore');
    }

    public function belongsAutori() {
        return $this->hasMany(Libri_Autori::class, 'ISBN');
    }

    public function belongsGeneri() {
        return $this->hasMany(Libri_Generi::class, 'ISBN');
    }

    public function belongsLingua() {
        return $this->belongsTo(Lingua::class, 'lingua');
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
                    $row['Autori']  .= $autore->belongsAutore->autore . ', ';

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
