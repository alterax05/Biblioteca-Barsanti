@extends('template.layout')
@section('title')
    {{ __('home.title') }} - Biblioteca
@endsection

@section('content')
    <div class="container col-md-9 col-lg-12 col-9" style="max-width: 1200px;">
        <div class="col-lg-12 row">
            <div class="col-4">
                <div class="cc-card categories">
                    <ul>
                        <li>{{ __('home.cataloghi') }}</li>
                        @foreach($reparti as $reparto)
                            <a href="/search/sezione/{{$reparto->id_reparto}}">
                                <li><i class="{{ $reparto->icon }}"></i> {{ __('categorie.' . $reparto->reparto) }} ({{ $reparto->numeri ?? 0 }})</li>
                            </a>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-8" style="padding: 0;">
                <div id="banner" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @for($i = 0; $i < count($carousel); $i++)
                            <li data-target="#banner" data-slide-to="{{ $i }}" class="active"></li>
                        @endfor
                    </ol>
                    <div class="carousel-inner">
                        @for($i = 0; $i < count($carousel); $i++)
                        <div class="carousel-item {{ ($i == 0)?'active':'' }}">
                            <div class="banner">
                                <div class="banner-wrapper">
                                    <h5>{{ $carousel[$i]->title }}</h5>
                                    <p>{!! $carousel[$i]->subtitle !!}</p>
                                    @if($carousel[$i]->autore != null)
                                        <a href="/search/autore/{{ $carousel[$i]->autore }}">{{ __('home.more') }}</a>
                                    @endif
                                </div>
                                <img src="{{$carousel[$i]->image}}">
                            </div>
                        </div>
                        @endfor
                    </div>
                    <a class="carousel-control-prev" href="#banner" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Indietro</span>
                    </a>
                    <a class="carousel-control-next" href="#banner" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Avanti</span>
                    </a>
                </div>

                @foreach($autori_bacheca as $autore)
                    <div class="autori-card cc-card">

                        <div class="autori-bacheca">
                            <img class="img-autori" src="/imgs/authors/{{ $autore->id_autore }}.webp">
                            <div>
                                <p>{{ __('home.discover') }} {{ $autore->autore }} ({{ $autore->location }}) <a href="/search/autore/{{ $autore->id_autore }}">{{ __('home.more') }}</a></p>
                                <label>{{ $autore->subtitle }}</label>
                            </div>
                        </div>

                        <div class="row">
                            @foreach($autore->libri as $libro)
                            <div class="col-3">
                                <a href="/book/{{ $libro->ISBN }}">
                                    <img style="width: 100%;" onerror="imgError(this)" src="/covers/{{ $libro->ISBN }}">
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="news-wrapper d-table col-lg-12">
            <div class="news float-left col-lg-4">

            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script src="/js/app.js"></script>
@endsection
