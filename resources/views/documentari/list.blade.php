@extends('template.documentari')
@section('title')
    {{ __('home.title') }} - Biblioteca
@endsection

@section('doc-content')
    <div class="info">
        <div class="row" style="width: 100%; margin-top: -20px;">
            @foreach($documentari as $doc)
            <div class="video-wrapper col-4">
                <a href="/documentaries/{{$doc->id_documentario}}">
                <div class="cc-card video-cc">
                    <div class="cover-video" style="background-image: url({{ $doc->id_tipologia == "1"? "https://i.ytimg.com/vi/".$doc->embed."/hqdefault.jpg" : $doc->thumbnail }})">
                        <div class="module-bg"></div>
                    </div>
                    <div class="info">
                        <h5>{{ $doc->titolo }}</h5>
                        <p>{{ $doc->subtitolo }}</p>
                    </div>
                    <img src="/imgs/{{$doc->icona}}" class="fornitore">
                </div>
                </a>
            </div>
            @endforeach
        </div>
        {{ $documentari->links() }}
    </div>
@endsection
@section('script')
    <script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
    <script src="/js/app.js"></script>
@endsection
