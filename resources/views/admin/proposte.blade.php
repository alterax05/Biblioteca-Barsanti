@extends('template.admin')
@section('admin-content')
    <h5>Proposte</h5>
    <div class="libri">
        @foreach($proposte as $libro)
            <div class="card" style="margin-bottom: 20px;">
                <div class="libro row">
                    <div class="col-3">
                        <img  src="/covers/{{$libro->ISBN}}" alt="cover">
                    </div>
                    <div class="col-9 row">
                        <div class="col-8">
                            <p class="{{ (strlen($libro->titolo) > 100)? 'too-long': '' }}"><a href="/book/{{$libro->ISBN}}">{{ $libro->titolo }}</a></p>
                            <p>@if(count($libro->belongsAutori) != 0)
                                    {{ __('book.of') }}
                                    @foreach($libro->belongsAutori as $autore)
                                        <a href="/search/autore/{{ $autore->id_autore }}?page=1">{{ $autore->autore }}</a>
                                    @endforeach
                                @endif
                            </p>
                            <p><a href="/search?editore={{ $libro->belongsEditore->id_editore }}&page=1">{{ $libro->belongsEditore->editore }}</a>, {{ $libro->anno_stampa }}</p>

                            @if(count($libro->belongsGeneri) != 0)
                                <div class="genere">
                                    <p>{{ __('book.generi') }}:</p>
                                    <div class="d-flex flex-column">
                                        @foreach($libro->belongsGeneri as $genere)
                                            <a href="/search?genere={{ $genere->id_genere }}&page=1">{{ $genere->genere }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-4">
                            <p style="font-size: 14px">Status:</p>
                            <span class="badge btn-warning" style="color: #000">{{ $libro->status == 0? 'In revisione' : 'Acquistato' }}</span>
                            <p style="margin-top: 20px; font-size: 14px;">Proposte:</p>
                            <span>{{ $libro->proposte }} utenti</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@section('style')
    <style>
        .dettagli > p {
            font-size: 13px;
            margin-bottom: 5px;
        }
    </style>
@endsection
