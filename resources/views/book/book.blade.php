@extends('template.layout')
@section('title')
    @if(strlen($libro->titolo) < 40)
        {{ $libro->titolo }}
    @else
        {{ explode('.', $libro->titolo)[0] }}
    @endif
@endsection

@section('content')
    <div x-data="bookComponent()">
        <div class="container row" style="margin: 0 auto; max-width: 1200px;">
            <div class="col-4">
                <img  style="width: 100%; border: solid 1px #c4c4c4;" src="/covers/{{$libro->ISBN}}" alt="cover">
            </div>
            <div class="col-8" style="margin-bottom: 40px;">
                <div class="col-lg-12 row">
                    <label style="font-size: 14px;cursor: pointer;">
                        <a on_click="history.back();">< {{ __('book.back') }}</a>
                    </label>
                    <div class="col-8 dati">
                        <p>{{ $libro->titolo }}</p>
                        <p>{{ __('book.of') }}
                            @foreach($libro->belongsAutori as $autore)
                                <a href="/search/autore/{{ $autore->id_autore }}/?page=1">{{ $autore->autore }}</a>
                            @endforeach
                        </p>
                        <p class="edizione"><a href="/search?editore={{ $libro->belongsEditore->id_editore }}&page=1">{{ $libro->belongsEditore->editore }}</a>, {{ $libro->anno_stampa }}</p>

                        @if(count($libro->belongsGeneri) != 0)
                            <div class="genere">
                                <p>{{ __('book.generi') }}:</p>
                                <div class="d-flex flex-column">
                                    @foreach($libro->belongsGeneri as $genere)
                                        <a style="width: fit-content;" href="/search?genere={{ $genere->id_genere }}&page=1">{{ $genere->genere }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(Auth::check())
                            <div class="d-flex" style="margin-top: 20px">
                                <div class="d-block">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">

                                    <div class="d-flex medie">
                                        <template x-for="(star, index) in Array(5).fill(0)">
                                            <i :class="{'fas fa-star rec': true, 'removed': index >= punteggio}" @click="recensioni(index + 1)"></i>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            @if(count($copie) != 0)
                                <button style="margin-top: 20px" type="button" class="btn btn-primary" data-toggle="modal" data-target="#prenota">
                                    {{ __('book.book') }}
                                </button>
                            @endif
                        @endif
                    </div>
                    <div class="col-4 qrcode-prestito" style="margin-bottom: 30px;">
                        <label>{{ __('book.phone') }}</label>
                        <div class="qrcode">
                            <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{ env('APP_URL') }}/book/{{$libro->ISBN}}/&choe=UTF-8" title="Visualizzalo sul telefono" />
                        </div>
                    </div>

                    <div class="cc-card" style="padding: 0;margin-top: 20px;">
                        <div class="info-book">
                            @if($libro->descrizione != "")
                            <div class="descrizione d-flex flex-column">
                                <label><b>{{ __('book.description') }}</b></label>
                                {!! (strlen($libro->descrizione > 650)) ?substr($libro->descrizione, 0, 650) . "..." : $libro->descrizione !!}
                            </div>
                            @endif
                            <div class="row col-lg-12">
                                <div class="col-5">
                                    @if($libro->pagine != 0)
                                        <p><i class="far fa-file"></i> {{ __('book.pages') }}: <b>{{ $libro->pagine }} p.</b></p>
                                    @endif
                                    <p><i class="fas fa-barcode"></i> ISBN: <b>{{ $libro->ISBN }}</b></p>
                                    <img class="barcode" src="/api/barcode/{{$libro->ISBN}}" alt="barcode">
                                </div>
                                <div class="col-7">
                                    <p><i class="fas fa-language"></i> {{ __('book.language') }}: <a href="/search?lingua={{$libro->lingua}}&page=1"><b>{{ $libro->belongsLingua->lingua }}</b></a></p>
                                    <p><i class="fas fa-arrows-alt-v"></i> {{ __('book.physics') }}: <b>{{ $libro->altezza }}</b></p>
                                </div>
                            </div>
                        </div>
                        @if(count($copie) > 0)
                            <div class="col-lg-12 prestati">
                                <div class="prestato row header-table">
                                    <p class="col-2">{{ __('book.code_book') }}</p>
                                    <p class="col-3">{{ __('book.place') }}</p>
                                    <p class="col-2">{{ __('book.loans') }}</p>
                                    <p class="col-3">{{ __('book.conditions') }}</p>
                                    <p class="col-2">{{ __('book.availability') }}</p>
                                </div>
                                @foreach($copie as $copia)
                                    <div class="prestato row riga">
                                        <p class="col-2">{{ $copia->num_copia }} @if($copia->da_catalogare == 1)({{ __('book.provvisorio') }})@endif</p>
                                        <p class="col-3" style="font-size: 13px;"><b>{{ __('book.scaffale') }}</b> {{ $copia->scaffale }} <b>{{ __('book.ripiano') }}</b> {{ $copia->ripiano }}</p>
                                        <p class="col-2">{{ $copia->prestati }} {{ __('book.times') }}</p>
                                        <p class="col-3">{{ $copia->condizioni }}</p>
                                        @if($copia->da_catalogare == 0)
                                            <p class="col-2">{{ ($copia->prestiti > 0)? __('book.borrowed') : __('book.available') }}</p>
                                        @else
                                            <p class="col-2">{{ __('book.borrowed') }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @if($scheda != null)
                        <div class="autori-card cc-card">

                            <div class="autori-bacheca">
                                <img class="img-autori" src="/imgs/authors/{{ $scheda->id_autore }}.webp">
                                <div>
                                    <p>{{ __('book.discover')  }} {{ $autore->autore }} ({{ $scheda->location }})</p>
                                    <a href="/search/autore/{{ $autore->id_autore }}">{{ __('book.show_all') }}</a>
                                </div>
                            </div>

                            <div class="row">
                                @foreach($libri as $libro)
                                    <div class="col-3">
                                        <img  src="/covers/{{ $libro->ISBN }}">
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="toast" style="position: absolute; top: 180px; right: 0;">
            <div class="toast-header">
                <strong class="mr-auto">{{ __('book.notifiche') }}</strong>
                <button type="button" class="ml-2 mb-1 close-form" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                {{ __('book.recensione_success') }}
            </div>
        </div>

        <div>
            <div x-show="showModal" class="modal fade" id="prenota" tabindex="-1" role="dialog" aria-labelledby="prenota" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="prenota">{{ __('book.copy_book') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ __('book.inventory_code') }}</label>
                                <select class="form-select" x-model="id_copia">
                                    @foreach($copie as $copia)
                                        <option value="{{ $copia->id_copia }}">{{ $copia->num_copia }} - ({{ __('book.scaffale_down') }}: {{ $copia->scaffale }}, {{ __('book.ripiano_down') }}: {{ $copia->ripiano }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 15px;margin: 15px 0 0;">{{ __('book.ritira') }}</label>
                            </div>
                            <div class="form-group">
                                <label class="error" style="margin-top: 20px;color: #c11616;"></label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="font-size: 14px" class="btn btn-secondary" data-dismiss="modal">{{ __('book.close') }}</button>
                            <button type="button" class="btn btn-primary" @click="prenotazione()">{{ __('book.book_button') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("script")
    <script>
function bookComponent() {
    return {
        punteggio: '{{$punteggio}}',
        id_copia: "{{$copie[0]->id_copia ?? 0}}",
        showModal: false,
        ISBN: "{{$libro->ISBN}}",
        recensioni(recensione) {
            console.log(recensione);
            axios({
                url: "/api/recensioni/",
                method: 'post',
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "X-Requested-With": "XMLHttpRequest",
                },
                data: {
                    ISBN: this.ISBN,
                    punteggio: recensione,
                },
            })
            .then((response) => {
                if (response.status === 200) {
                    document.querySelector(".toast").classList.add("show");
                    document.querySelector(".toast .toast-body").innerHTML = "Recensione salvata con successo!";
                    this.punteggio = recensione;
                }
            });
        },
        prenotazione() {
            axios.post("/api/prenotazione", {
                id_copia: this.id_copia,
            }, {
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "X-Requested-With": "XMLHttpRequest",
                },
            })
            .then((response) => {
                if (response.status === 200) {
                    if (response.data === "Prenotazione salvata!") {
                        this.showModal = false;
                        document.querySelector(".toast").classList.add("show");
                        document.querySelector(".toast .toast-body").innerHTML = "Prenotazione salvata con successo!";
                    } else {
                        document.querySelector("#prenota .error").innerHTML = response.data;                    }
                }
            });
        },
    }
}

</script>
    <style>
        .cc-card .info-book {
            padding: 20px 20px;
            margin-top: 20px;
        }
        .col-lg-12 .dati > p:nth-child(1) {
            font-size: 24px;
            font-weight: bold;
        }
        .col-lg-12 .dati > p:nth-child(2) {
            font-size: 14px;
            margin-bottom: 15px;
        }
        .col-lg-12 .dati > p:nth-child(3) {
            font-weight: 300;
        }
        .col-lg-12 .info-book > p:nth-child(1) {
            margin-bottom: 10px;
        }
        .col-lg-12 .info-book > div > p:nth-child(2) {
            margin-bottom: 10px;
            font-size: 50px;
            font-weight: 800;
        }
        .col-lg-12 .info-book > .row div > p{
            font-weight: 300;
        }
        .col-lg-12 .info-book > .row div:nth-child(2) > p {
            text-align: right;
        }
        .prestato.row.header-table {
            background: #f7f5f5;
            border-top: solid 1px #bfbfbf;
            margin-top: 40px;
        }
        .prestato.row {
            padding: 15px 15px;
            font-weight: 300;
            font-size: 14px;
            margin-left: 0;
            margin-right: 0;
        }
        .prestato.row > * {
            padding: 0 10px;
        }
        .edizione a {
            color: unset;
        }
        .prestato.row.header-table {
            background: #f0f0f0;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        .prestato.row.riga:nth-child(odd) {
            background: #f4f4f4;
        }
        .qrcode-prestito {
            padding: 0;
        }
        .qrcode-prestito img {
            width: 100%;
            transform: scale(1.2);
        }
        .qrcode {
            width: 150px;
            height: 150px;
            float: right;
            overflow: hidden;
            border: solid 1px #8a8a8a;
        }

    </style>
    <style>

        .medie > i {
            font-size: 26px !important;
            margin: 10px 2px;
        }

    </style>
@endsection
