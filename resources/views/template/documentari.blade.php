@extends('template.layout')

@section('content')
    <div class="container row col-lg-10" style="margin: 0 auto;">
        <div class="col-12">
            @yield('video-content')
        </div>
        <div class="col-3">
            <div class="row">
                <div class="col-6"><h4>Categorie</h4></div>
                <div class="col-6 add-button" data-toggle="modal" data-target="#add_documentario">
                    <button class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="cc-card admin-menu">
                <ul>
                    @foreach($reparti as $reparto)
                        @if($reparto->numeri > 0)
                            <a href="/documentaries/list/{{$reparto->id_reparto}}"><li><i class="{{ $reparto->icon }}"></i> {{ __('categorie.'.$reparto->reparto) }} ({{ $reparto->numeri }})</li></a>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-9">
            @yield('doc-content')
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="add_documentario" tabindex="-1" role="dialog" aria-labelledby="add_documentario" aria-hidden="true">
        <form method="POST" action="/documentaries">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Aggiungi un documentario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="video">Link del video youtube</label>
                                <input type="text" class="form-control" id="video" name="video" placeholder="Link youtube">
                            </div>
                        </div>
                        <div class="form-row" style="margin-top: 20px;">
                            <div class="form-group col-md-12">
                                <label for="inputPassword4">Tipologia</label>
                                <select class="form-select" name="tipologia">
                                    @foreach($reparti as $reparto)
                                        <option value="{{$reparto->id_reparto}}">{{ __('categorie.'.$reparto->reparto) }}</option>
                                    @endforeach
                                </select>
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
@section('style')
    <style>
        .form-group.col-md-12 > label {
            font-size: 14px;
        }
        .form-group.col-md-12 > input {
            font-size: 13px;
        }
        .modal-footer > button {
            font-size: 13px;
        }
    </style>
@endsection
