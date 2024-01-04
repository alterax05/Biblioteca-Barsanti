@extends('template.admin')
@section('title', 'Inserimento dati - Biblioteca')

@section('admin-content')
        <div class="cc-card filter-card">
            <h5>Aggiungi un libro</h5>
            <form method="POST">
                <div class="input-wrapper row">
                    @csrf
                    <div class="col-12">
                        <label>Inserisci l'ISBN del libro (ISBN 13 es. <b>97888</b>12345678)</label>
                        <a href="/admin/insert/advanced" style="display: block">Non c'è l'ISBN</a>
                        @if(count($dafare) == 0)
                            <input style="width: 100%;" name="isbn" type="text" placeholder="ISBN" class="isbn" required>
                        @else
                            <select name="isbn">
                                @foreach($dafare as $df)
                                    <option value="{{ $df->ISBN }}">{{ $df->ISBN }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>

                <div class="input-wrapper row">
                    <div class="col-6">
                        <label>Seleziona le sue condizioni</label>
                        <select name="condizioni" class="form-select" style="width: 100%; height: min-content;" required>
                            @foreach($condizioni as $condizion)
                                <option value="{{ $condizion->id_condizioni }}">{{ $condizion->condizioni }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label>Inserisci lo scaffale (Num. A/B)</label>
                        <input name="scaffale" value="{{ $_GET['scaffale']??"" }}" type="text" style="width: 100%; padding: 3px 20px;" required>
                    </div>
                </div>

                <div class="input-wrapper row">
                    <div class="col-6">
                        <label>Inserisci il ripiano</label>
                        <input name="ripiano" value="{{ $_GET['ripiano']??"" }}" type="text" style="width: 100%; padding: 3px 20px;" required>
                    </div>
                    <div class="col-6">
                        <label>Inserisci il codice inventario</label>
                        <input name="codice" type="text" style="width: 100%; padding: 3px 20px;" required>
                    </div>
                </div>
                <div class="input-wrapper row">
                    <div class="col-6">
                        <label>Inserisci le volte prestate</label>
                        <input name="prestati" value="0" type="text" style="width: 100%; padding: 3px 20px;" required>
                    </div>
                    <div class="col-6">
                        <label>Seleziona il reparto</label>
                        <select name="reparto" class="form-select" style="width: 100%; height: min-content;" required>
                            @foreach($reparti as $reparto)
                                <option value="{{ $reparto->id_reparto }}">{{ $reparto->reparto }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-primary">Inserisci il libro</button>
                    </div>
                </div>
            </form>
            @if(!empty($message))
                <label>{{ $message }}</label>
            @endif
        </div>
@endsection
