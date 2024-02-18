@extends('template.profile')
@section('profile-content')
    <div class="col-8">
        <div style="margin-bottom: 20px;">
            @if(!$restituzione)
            <a href="/profile/generate">
                <button class="btn btn-primary"><i class="fa-solid fa-cloud-arrow-down"></i> {{ __('profile.export') }}</button>
            </a>
            @endif
        </div>

        <h5>{{ (!$restituzione)? __('profile.in_corso') : __('profile.returned') }}</h5>
        <div class="libri">
            @foreach($prestiti as $libro)
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
                            <label class="copie">{{ __('profile.book_il') }}: <b>{{ date("d/m/Y", strtotime($libro->data_prestito)) }}</b></label>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
