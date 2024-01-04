@extends('template.admin')
@section('title', 'Libro - Biblioteca')

@section('admin-content')
    <div class="cc-card filter-card">
        <div class="row">
            <div class="col-4">
                <img class="book-cover" src="https://pictures.abebooks.com/isbn/{{ $libro->ISBN }}-us-300.jpg" style="width: 100%;">
            </div>
            <div class="col-8">
                <h5 style="margin-top: 20px;">Titolo: {{ $libro->titolo }}</h5>
            </div>
        </div>

        <div class="input-wrapper row">
            <div class="col-12">
                <form method="POST" id="autoreForm" action="/admin/book/{{ $libro->ISBN }}/authors">
                    @csrf
                    <label>Autori</label>
                    <textarea readonly class="form-control" style="margin-bottom: 20px; font-size: 14px;">@foreach($autori as $autore){{ $autore->autore }}, @endforeach</textarea>
                    <label style="font-size: 14px;">Aggiungi un autore</label>
                    <select class="form-select" name="author" style="height: fit-content;">
                        @foreach($autoriAll as $autore)
                            <option value="{{ $autore->id_autore }}">{{ $autore->autore }}</option>
                        @endforeach
                    </select>
                    <button onclick="$('autoreForm').submit()" class="btn-primary btn" style="font-size: 12px; margin-top: 10px;">Aggiungi un autore</button>
                </form>
            </div>
        </div>
        <form method="POST">
            <div class="input-wrapper row">
                @csrf
                <div class="col-12">
                    <label>ISBN del libro</label>
                    <input style="width: 100%;" name="isbn" value="{{ $libro->ISBN }}" type="text" placeholder="ISBN" class="isbn" required>
                </div>
            </div>

            <div class="input-wrapper row">
                <div class="col-6">
                    <label>Inserisci lo scaffale (Num. A/B)</label>
                    <input name="scaffale" value="{{ $libro->scaffale }}" type="text" style="width: 100%; padding: 3px 20px;" required>
                </div>
                <div class="col-6">
                    <label>Inserisci le persone a cui è stato prestato (default: 0)</label>
                    <input name="prestati" value="0" type="text" value="{{$libro->prestiti}}" style="width: 100%; padding: 3px 20px;" required>
                </div>
            </div>

            <div class="input-wrapper row">
                <div class="col-6">
                    <label>Inserisci il ripiano</label>
                    <input name="ripiano" value="{{ $libro->ripiano }}" type="text" style="width: 100%; padding: 3px 20px;" required>
                </div>
                <div class="col-6">
                    <label>Inserisci il codice inventario</label>
                    <input name="codice" type="text" value="{{ $libro->id_libro }}" style="width: 100%; padding: 3px 20px;" required>
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
