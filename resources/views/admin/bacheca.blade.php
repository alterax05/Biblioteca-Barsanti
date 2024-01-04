@extends('template.admin')
@section('title', 'Admin - Biblioteca')

@section('admin-content')
    <div class="row">
        <div class="col-6"><h4>Autori in bacheca</h4></div>
        <div class="col-6 add-button" data-toggle="modal" data-target="#add_autore">
            <button class="btn btn-primary">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

    <div class="row">
        @foreach($autori_bacheca as $autore)
        <div class="col-12">
                <div class="autori-card cc-card" style="margin: 10px 0">
                    <div class="autori-bacheca">
                        <img class="img-autori" src="/imgs/authors/{{ $autore->id_autore }}.jpg">
                        <div class="row" style="width: 100%">
                            <div class="col-10">
                                <p>{{ $autore->autore }}</p>
                                <small>{{ $autore->subtitle }}</small>
                            </div>
                            <div class="col-2 delete-wrapper">
                                <a href="/admin/bacheca/delete/{{ $autore->id_autore }}">
                                    <i class="fa-solid fa-delete-left"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
        </div>
        @endforeach
    </div>


    <!-- Modal -->
    <div class="modal fade" id="add_autore" tabindex="-1" role="dialog" aria-labelledby="add_autore" aria-hidden="true">
        <form method="POST">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Aggiungi un autore</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row" style="margin-bottom: 20px;">
                            <div class="form-group col-md-12">
                                <label for="video">Seleziona l'autore</label>
                                <select class="form-select" id="video" name="autore">
                                    @foreach($autori as $autore)
                                        <option value="{{$autore->id_autore}}">{{ $autore->autore }}</option>
                                    @endforeach
                                </select>
                                <small>Per cercare più velocemente un autore, seleziona l'elenco e poi scrivi il nome dell'autore.</small>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="subtitle">Inserisci il sotto titolo</label>
                                <input type="text" class="form-control" id="subtitle" aria-describedby="emailHelp" name="subtitle">
                                <small>E' il messaggio sotto all'annuncio: es. "50 anni dalla morte etc."</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                        <button type="submit" class="btn btn-primary">Aggiungi</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
