@extends('template.profile')
@section('profile-content')
    <div class="col-8">

        <h5>{{ __('profile.booked_copy') }}</h5>
        <div class="libri">
            @foreach($prestiti as $libro)
                <div class="libro row cc-card spacer-card">
                    <div class="col-3">
                        <a href="/book/{{$libro->ISBN}}">
                            <img  src="/covers/{{ $libro->ISBN }}" alt="cover">
                        </a>
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
                        <div class="col-4 dettagli">
                            <label class="copie">{{ __('profile.booked_in') }}: <b>{{ date("d/m/Y", strtotime($libro->created_at)) }}</b></label>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
