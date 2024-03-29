@extends('template.admin')
@section('title', 'Inserimento dati - Biblioteca')

@section('admin-content')
    <div class="cc-card filter-card">
        <h5>Aggiungi un libro <b>senza ISBN</b></h5>
        <form method="POST">
            <div class="input-wrapper row">
                @csrf
                <div class="col-12">
                    <label>Inserisci il titolo del libro</label>
                    <input name="titolo" type="text" placeholder="Titolo del libro" class="isbn" required>
                </div>
            </div>

            <div class="input-wrapper row">
                <div class="col-6">
                    <label>Seleziona il genere</label>
                    <select name="genere" class="form-select" style="width: 100%; height: min-content;" required>
                        @foreach($generi as $genere)
                            <option value="{{ $genere->id_genere }}">{{ $genere->genere }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label>Inserisci l'anno di stampa</label>
                    <input name="anno" type="text" style="width: 100%; padding: 3px 20px;" required>
                </div>
            </div>

            <div class="input-wrapper row" x-data="autoreDropdown()">
                
                <div class="col-6" @click.away="autori = null">
                    <label>Seleziona l'autore</label>
                    <div style="position: relative">
                        <input 
                            x-model="autore" 
                            @input="update" 
                            id="autore" 
                            name="autore" 
                            type="text" 
                            style="width: 100%; padding: 3px 20px;" 
                            required 
                            autocomplete="off"
                        >
                        <ul class="search-list" x-show="autori && autori.length">
                            <template x-for="(row, index) in autori" :key="index">
                                <li @click="changeValue(row.autore)">
                                    <div class="option-search">
                                        <div class="col-lg-12">
                                            <p x-html="row.autore"></p>
                                        </div>
                                    </div>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>

                <div class="col-6">
                    <label>Seleziona l'editore</label>
                    <select name="editore" class="form-select" style="width: 100%; height: min-content;" required>
                        @foreach($editori as $editore)
                            <option value="{{ $editore->id_editore }}">{{ $editore->editore }}</option>
                        @endforeach
                    </select>
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
                    <input name="id_libro" type="text" style="width: 100%; padding: 3px 20px;" required>
                </div>
            </div>
            <div class="input-wrapper row">
                <div class="col-6">
                    <label>Inserisci le volte prestate</label>
                    <input name="prestati" value="0" type="text" style="width: 100%; padding: 3px 20px;" required>
                </div>
                <div class="col-6">
                    <label>Seleziona la lingua</label>
                    <select name="lingua" class="form-select" style="width: 100%; height: min-content;" required>
                        <option value="it">Italiano</option>
                        <option value="en">Inglese</option>
                        <option value="de">Tedesco</option>
                        <option value="es">Spagnolo</option>
                        <option value="fr">Francese</option>
                    </select>
                </div>
            </div>

            <div class="input-wrapper row">
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

@section('style')
    <style>
        .search-list {
            width: 100% !important;
            border: solid 1px #d2d2d2;
        }
        input[name="autore"] {
            font-size: 14px;
        }
    </style>

@endsection

@section('script')
    <script>
        function autoreDropdown() {
            return {
                autore: '',
                autori: null,
                update(event) {
                    const value = event.target.value;

                    if (value.length > 2) {
                        let url = encodeURI(`/api/autori/${value}`);
                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                this.autori = data;
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    } else {
                        this.autori = null;
                    }
                },
                changeValue(value) {
                    this.autore = value;
                    this.autori = null;
                }
            }
        }
    </script>
@endsection
