@extends('template.documentari')
@section('title')
    {{ __('home.title') }} - Biblioteca
@endsection

@section('video-content')
    <div class="cc-card" style="margin-bottom: 30px;background: #000;height: 550px;">

        @if($documentario->id_fornitore == "1")
            <iframe style="width: 100%;height: 100%;" src="https://www.youtube.com/embed/{{ $documentario->embed }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        @else
            <video
                id="my-video"
                class="video-js"
                controls
                preload="auto"
                poster="{{ $documentario->thumbnail }}"
                data-setup="{}">
                    <source src="{{ $documentario->embed }}" type="application/x-mpegURL" />
                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider upgrading to a
                        web browser that
                        <a href="https://videojs.com/html5-video-support/" target="_blank"
                        >supports HTML5 video</a
                        >
                    </p>
            </video>
        @endif
    </div>
@endsection
@section('doc-content')
    <div class="cc-card info">
        <div class="row">
            <div class="col-8">
                <h4>{{ $documentario->titolo }}</h4>
                <p class="author-doc" style="margin-bottom: 20px">{{ $documentario->subtitolo }}</p>
                <p>Categoria:
                    <a href="/documentaries/list/{{$documentario->belongsTipologia->id_reparto}}">
                        <b>{{ __('categorie.'.$documentario->belongsTipologia->reparto) }}</b>
                    </a></p>
            </div>
            <div class="col-4" style="text-align: right">
                <img src="/imgs/{{ $documentario->icona }}" alt="logo-doc">
                <p style="margin-top: 20px">Fornitore <b>{{ $documentario->fornitore }}</b></p>
                <div class="share" style="font-size: 15px">
                    <a href="{{$documentario->link ?? "http://www.youtube.com/watch?v=".$documentario->embed}}" target="_blank">
                        <i class="fa-solid fa-share-from-square"></i>
                        Vai sulla pagina ufficiale
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
    <script src="/js/app.js"></script>
@endsection
