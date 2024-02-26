@extends('template.admin')
@section('admin-content')
        <h5>Prestiti in corso <i class="fa-solid fa-arrow-up-1-9"></i></h5>
        <div class="libri">
            @foreach($prestiti as $libro)
                <div class="libro row cc-card spacer-card">
                    <div class="col-2">
                        <a href="/book/{{$libro->ISBN}}">
                            <img style="width: 100%"  src="/covers/{{ $libro->ISBN }}-us-300.jpg" alt="cover">
                        </a>
                    </div>
                    <div class="col-9 row">
                        <div class="col-8">
                            <p class="{{ (strlen($libro->titolo) > 100)? 'too-long': '' }}"><a href="/book/{{$libro->ISBN}}">{{ $libro->titolo }}</a></p>
                            <p>@if(count($libro->belongsAutori) != 0)
                                    di
                                    @foreach($libro->belongsAutori as $autore)
                                        <a href="/search/autore/{{ $autore->id_autore }}?page=1">{{ $autore->autore }}</a>
                                    @endforeach
                                @endif
                            </p>
                            <!--<p><a href="?editore={{ $libro->belongsEditore->id_editore }}&page=1">{{ $libro->belongsEditore->editore }}</a>, {{ $libro->anno_stampa }}</p>-->
                            <p style="margin-top: 10px;font-size: 15px;">Prestato a: {{ $libro->name }} {{ $libro->surname }} (<b>{{$libro->class}}</b>)</p>
                        </div>
                        <div class="col-4 dettagli" style="margin-top: 0;">
                            <p><b>Data prestito:</b> {{ $libro->data_inizio }}</p>
                            <p><b>Scaffale:</b> {{ $libro->scaffale }}, ripiano: {{ $libro->ripiano }}</p>
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
