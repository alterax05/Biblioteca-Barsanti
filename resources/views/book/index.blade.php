@extends('template.layout')
@section('title')
        Ricerca tra i libri - Biblioteca
@endsection

@section('content')
    <div class="container row" style="margin: 0 auto; max-width: 1200px;">

        <label><a href="/" id="turn">< {{ __('catalogue.back') }}</a></label>

        <div class="col-4">
                <div class="cc-card filter-card" style="margin-bottom: 20px;">
                    <div class="d-table" style="width: 100%">
                        <p>{{ __('catalogue.filters') }}</p>

                        <div v-if='editore != 0' class="filter" @click="clearVariable(() => editore = 0, 'editore')">
                            <a style="text-decoration: none; color: unset;"><span>{{ __('catalogue.editore') }} <label class="close-x">+</label></span></a>
                        </div>

                        <div v-if='autore != 0' class="filter" @click="clearVariable(() => autore = 0, 'autore')">
                            <a style="text-decoration: none; color: unset;"><span>{{ __('catalogue.autore') }} <label class="close-x">+</label></span></a>
                        </div>

                        <div v-if='genere != 0' class="filter" @click="clearVariable(() => genere = 0, 'genere')">
                            <a style="text-decoration: none; color: unset;"><span>{{ __('catalogue.genere') }} <label class="close-x">+</label></span></a>
                        </div>
                    </div>
                    <a style="margin-top: 20px;" class="btn btn-primary filter-toggler" data-toggle="collapse" href="#filterBlock" role="button" aria-expanded="false" aria-controls="filterBlock">
                        Apri le opzioni di filtro
                    </a>
                </div>

            <div class="collapse" id="filterBlock" style="max-width: 1200px;">
                <div class="cc-card">

                    <div class="filter-card" v-if="autori.length !== 0">
                        <p>{{ __('catalogue.autori') }}</p>
                        <ul>
                            <li v-for="autoreF in autori" :key="'filter'+autoreF.id_autore">
                                <a @click="change(() => autore = autoreF.id_autore, 'autore', autoreF.id_autore)" v-html="autoreF.autore"></a> <span class="numFilter" v-html="'('+autoreF.numero+')'"></span>
                            </li>
                        </ul>
                    </div>

                    <div class="filter-card" v-if="generi.length !== 0">
                        <p>{{ __('catalogue.generi') }}</p>
                        <ul>
                            <li v-for="genereF in generi" :key="'filter'+genereF.id_genere">
                                <a @click="change(() => genere = genereF.id_genere, 'genere', genereF.id_genere)" v-html="genereF.genere"></a> <span class="numFilter" v-html="'('+genereF.numero+')'"></span>
                            </li>
                        </ul>
                    </div>

                    <div class="filter-card" v-if="editori.length !== 0">
                        <p>{{ __('catalogue.editori') }}</p>
                        <ul>
                            <li v-for="editoreF in editori" :key="'filter'+editoreF.id_editore">
                                <a @click="change(() => editore = editoreF.id_editore, 'editore', editoreF.id_editore)" v-html="editoreF.editore"></a> <span class="numFilter" v-html="'('+editoreF.numero+')'"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
                <label v-if="scheda_autore != null" style="margin-bottom: 10px;"><a @click="loadQuery('')">< Cerca su tutti i titoli</a></label>

                <div class="cc-card spacer-card row search-card" style="overflow: unset;">
                    <h5 style="border: none;" v-html="'{{ __('catalogue.results') }} ('+count+')'"></h5>
                    <div class="col-8">
                        <div class="search-wrapper">
                            <div id="search" action="">
                                <input autocomplete="off" id="searchInp" name="query" style="width: 100%" type="text" placeholder="{{ __('catalogue.search') }}" @input="update">
                                <i class="fas fa-search" @click="loadQuery('')"></i>
                            </div>
                        </div>
                        <ul class="search-list">
                            <li v-for="(row,rid) in libri" :key="rid">
                                <a @click="loadQuery(row.query)">
                                    <div class="option-search">
                                        <div class="col-lg-12">
                                            <p v-html="row.query"></p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-4">
                        <div id="orderForm">
                            <select @change="orderLoad" id="orderby" class="form-select" style="width: 100%">
                                <option value="default">{{ __('catalogue.orders.voti') }}</option>
                                <option value="annoDesc">{{ __('catalogue.orders.anno_desc') }}</option>
                                <option value="annoAsc">{{ __('catalogue.orders.anno_asc') }}</option>
                                <option value="titoloAsc">{{ __('catalogue.orders.titolo_asc') }}</option>
                                <option value="titoloDesc">{{ __('catalogue.orders.titolo_desc') }}</option>
                                <option value="prestati">{{ __('catalogue.orders.prestati') }}</option>
                                <option value="copie">{{ __('catalogue.orders.copie') }}</option>
                            </select>
                        </div>
                    </div>
            </div>

            <div v-if="scheda_autore != null" class="cc-card author-card row" style="margin-bottom: 20px;">
                <div class="d-flex">
                    <img :src="'/imgs/authors/'+scheda_autore.id_autore+'.jpg'">
                    <div class="author d-flex flex-column">
                        <p v-html="scheda_autore.belongs_autore.autore"></p>
                        <div class="d-flex flex-row">
                            <label v-html="scheda_autore.location + ' - ' + scheda_autore.anno_nascita"></label>
                            <label v-if="scheda_autore.anno_morte != 0" v-html="', ' + scheda_autore.anno_morte"></label>
                        </div>
                        <label v-if="scheda_autore.nobel != null">Premio Nobel per la Letteratura <b v-html="scheda_autore.nobel"></b></label>
                        <a class="btn btn-primary desc-collapse" data-toggle="collapse" href="#descCollapse" role="button" aria-expanded="false" aria-controls="descCollapse">
                            {{ __('catalogue.read_description') }}
                        </a>
                    </div>
                </div>
                <div class="descrizione-author">
                    <div class="collapse" id="descCollapse">
                        <label v-html="scheda_autore.descrizione"></label>
                    </div>
                </div>
            </div>

            <input id="page" type="hidden" value="{{ $_GET['page'] ?? 1 }}">
            <input id="query" type="hidden" value="{{ $_GET['query'] ?? "NaN" }}">
            <input id="orderby" type="hidden" value="{{ $_GET['orderby'] ?? "default" }}">

            @if(!empty($author))
                <input id="autore" type="hidden" value="{{ $author }}">
            @else
                <input id="autore" type="hidden" value="{{ $_GET['autore'] ?? "0" }}">
            @endif

            @if(!empty($sezione))
                <input id="sezione" type="hidden" value="{{ $sezione }}">
            @else
                <input id="sezione" type="hidden" value="0">
            @endif

            <input id="genere" type="hidden" value="{{ $_GET['genere'] ?? "0" }}">
            <input id="editore" type="hidden" value="{{ $_GET['editore'] ?? "0" }}">
            <meta name="csrf-token" content="{{ csrf_token() }}">

            <input id="nazione" type="hidden" value="{{ $nazione ?? 0 }}">

            <div class="libri">
                <div class="libro row cc-card spacer-card" v-for="book in books" :key="book.ISBN">
                    <div class="col-3">
                        <a :href="'/book/'+book.ISBN">
                            <img onerror="imgError(this)" :src="'/imgs/covers/'+ book.ISBN + '.jpg'" alt="cover">
                        </a>
                    </div>
                    <div class="col-9 row">
                        <div class="col-8">
                            <p class=""><a :href="'/book/'+book.ISBN" v-html="book.titolo"></a></p>
                            <p v-if="book.belongs_autori.length !== 0">
                                di
                                <a v-for="autoreF in book.belongs_autori" :key="autoreF.id_autore" @click="clearFilters(); change(() => autore = autoreF.id_autore, 'autore', autoreF.id_autore)" v-html="autoreF.belongs_autore.autore + ' '"></a>
                            </p>
                            <p><a @click="clearFilters(); change(() => editore = book.belongs_editore.id_editore, 'editore', book.belongs_editore.id_editore)" v-html="book.belongs_editore.editore"></a>, <span v-html="book.anno_stampa"></span></p>

                            <div class="d-flex" style="margin-top: 10px" v-if="book.media != 0">
                                <p class="media" v-html="Number(book.media).toFixed(2)"></p>
                                <div class="d-block align-self-center">
                                    <p v-if="book.media > 4.5" class="alert-book">{{ __('catalogue.suggested') }}</p>
                                    <div class="d-flex medie">
                                        <i v-for="n in Math.round(book.media)" class="fas fa-star"></i>
                                        <i v-for="n in 5-Math.round(book.media)" class="fas fa-star removed"></i>
                                    </div>
                                </div>
                            </div>

                                <div class="genere" v-if="book.belongs_autori[0] && book.belongs_autori[0].belongs_autore.belongs_scheda != null && book.belongs_autori[0].belongs_autore.belongs_scheda.nobel != null">
                                    <div class="d-flex flex-row">
                                        <img data-bs-toggle="tooltip" data-bs-placement="top" :title="book.belongs_autori[0].belongs_autore.belongs_scheda.belongs_nazione.nazione" class="flag-nobel" :src="'/imgs/flags/' + book.belongs_autori[0].belongs_autore.belongs_scheda.belongs_nazione.tag + '.png'">
                                        <label>Nobel per la Letteratura <b v-html="book.belongs_autori[0].belongs_autore.belongs_scheda.nobel"></b></label>
                                    </div>
                                </div>

                                <div class="genere" v-if="book.belongs_generi !== 0">
                                    <p>{{ __('catalogue.generi') }}:</p>
                                    <div class="d-flex flex-column">
                                        <a v-for="genereF in book.belongs_generi" :key="genereF.id_genere" @click="clearFilters(); change(() => genere = genereF.id_genere, 'genere', genereF.id_genere)" v-html="genereF.belongs_genere.genere"></a>
                                    </div>
                                </div>
                        </div>
                        <div class="col-4 dettagli">
                            <label class="copie">{{ __('catalogue.copie') }}: <b v-html="book.copie"></b></label>
                            <label class="copie">{{ __('catalogue.prestati') }}: <b v-html="book.prestiti"></b></label>

                            @if(Auth()->user())
                                <a :href="'/post/preferiti/'+book.ISBN" style="text-decoration: none" v-if="book.preferiti == null"><button class="d-block btn btn-primary" style="font-size: 12px;margin-bottom: 10px;">{{ __('catalogue.save_favourites') }}</button></a>
                                <a :href="'/post/preferiti/'+book.ISBN" style="text-decoration: none" v-if="book.preferiti === 1"><button class="d-block btn btn-danger" style="font-size: 12px;margin-bottom: 10px;">{{ __('catalogue.remove_favourites') }}</button></a>
                            @endif
                            <div v-if="(book.copie - book.prestiti) !== 0" class="status disponibile d-flex row-direction">
                                <i class="fas fa-check"></i><p>{{ __('catalogue.available') }}</p>
                            </div>
                            <div v-if="(book.copie - book.prestiti) === 0" class="status d-flex row-direction" style="color: darkred">
                                <i class="fas fa-times"></i><p style="margin-left: 5px;">{{ __('catalogue.not_available') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="lastPage != 1" class="pages cc-card filter-card row" style="margin-bottom: 50px;">
                <a class="button-clicker col-3">
                    <div v-if="page != 1" @click="change(() => page = parseInt(page) - 1, 'page', page)">
                        <svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        <span>{{ __('catalogue.back_page') }}</span>
                    </div>
                </a>

                <span class="col-6" style="text-align: center; letter-spacing: 3px;" v-html="'{{ __('catalogue.page') }}: ' + page"></span>

                <a v-if="page < lastPage" class="button-clicker col-3 text-right" @click="change(() => page = parseInt(page) + 1, 'page', page)">
                    <span>{{ __('catalogue.next_page') }}</span>
                    <svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <div class="loadingpage-wrapper" id="loading">
        <div class="loading-page">
            <img src="/imgs/login.gif">
        </div>
    </div>
@endsection
@section('script')
    @if(!empty($_GET['orderby']))
    <script>
        $(document).ready(function() {
            $('#orderForm select').val("{{$_GET['orderby']}}");
        });
    </script>
    @endif
    <script src="/js/app.js"></script>
@endsection
