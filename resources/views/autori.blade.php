@extends('template.layout')

@section('title', 'Autori - Biblioteca')
@section('content')
    <div class="container row col-lg-8 lettere-cont" style="margin: 0 auto;">
        <div class="cc-card" style="overflow: hidden">
            <div class="lettere">
                @foreach($lettere as $letter)
                    <a href="/autori/{{ $letter }}" class="@if($letter == $lettera) actived @endif">{{ $letter }}</a>
                @endforeach
            </div>
            <div class="autori row">
                @foreach($autori as $a)
                <div class="col-4 d-flex flex-column">
                    @foreach($a as $autore)
                        <a href="/search/autore/{{ $autore['id_autore'] }}">{{ $autore['autore'] }} ({{ $autore['libri'] }})</a>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection
