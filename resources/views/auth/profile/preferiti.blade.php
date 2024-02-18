@extends('template.profile')
@section('profile-content')
    <div class="col-8">

        <h5>{{ __('profile.your_favourites') }}</h5>
        <div class="libri">
            @foreach($preferiti as $libro)
                <div class="libro row cc-card spacer-card">
                    <div class="col-3">
                        <a href="/book/{{$libro->ISBN}}">
                            <img onerror="imgError(this)" src="/covers/{{ $libro->ISBN }}" alt="cover">
                        </a>
                    </div>
                    <div class="col-9 row">
                        <div class="col-8">
                            <p class="{{ (strlen($libro->titolo) > 100)? 'too-long': '' }}"><a href="/book/{{$libro->ISBN}}">{{ $libro->titolo }}</a></p>
                            <p>@if(count($libro->belongsAutori) != 0)
                                    {{ __('book.of') }}
                                    @foreach($libro->belongsAutori as $autore)
                                        <a href="/search/autore/{{ $autore->belongsAutore->id_autore }}?page=1">{{ $autore->belongsAutore->autore }}</a>
                                    @endforeach
                                @endif
                            </p>
                            <p><a href="/search?editore={{ $libro->belongsEditore->id_editore }}&page=1">{{ $libro->belongsEditore->editore }}</a>, {{ $libro->anno_stampa }}</p>

                            @if(count($libro->belongsGeneri) != 0)
                                <div class="genere">
                                    <p>{{ __('book.generi') }}:</p>
                                    <div class="d-flex flex-column">
                                        @foreach($libro->belongsGeneri as $genere)
                                            <a href="/search?genere={{ $genere->belongsGenere->id_genere }}&page=1">{{ $genere->belongsGenere->genere }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-4 dettagli">
                            @if(Auth()->user())
                                <a href="/post/preferiti/{{ $libro->ISBN }}" style="text-decoration: none"><button class="d-block btn btn-danger" style="font-size: 12px;margin-bottom: 10px;">{{ __('profile.remove_fav') }}</button></a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
