@extends('template.layout')
@section('title', 'Nazioni - Biblioteca')

@section('content')
    <div class="container col-md-8 col-12 col-lg-8">
        <div class="row">
            @foreach($nazioni as $nazione)
            <div class="col-4" style="float:left; margin-top: 30px;">
                <a href="/search/nazione/{{ $nazione->id_nazione }}">
                    <div class="cc-card flag-card">
                        <div class="header-card">
                            <img src="/imgs/flags/{{ $nazione->tag }}.png"><label>{{ __('nazioni.' . $nazione->nazione) }}</label>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
@endsection
