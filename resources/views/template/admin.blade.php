@extends('template.layout')

@section('content')
    <div class="container row col-lg-8" style="margin: 0 auto;">
        <div class="col-4">
            <h5>Pannello admin</h5>
            <div class="cc-card admin-menu">
                <div class="search-fast">
                    <form method="POST" action="/admin/restituisci">
                        @csrf
                        <restituisci></restituisci>
                    </form>
                </div>
                <ul>
                    <a href="/admin"><li @if(Route::is('admin.index')) actived @endif><i class="fas fa-home"></i> Bacheca</li></a>
                    <a href="/admin/insert"><li @if(Route::is('admin.insert')) actived @endif><i class="fas fa-book"></i> Aggiungi un libro</li></a>
                    <a href="/admin/prestiti"><li @if(Route::is('admin.prestiti')) actived @endif><i class="fas fa-stopwatch"></i> Libri in prestito</li></a>
                    <a href="/admin/prenota"><li @if(Route::is('admin.prenota')) actived @endif><i class="fa-solid fa-ear-listen"></i> Prenotazioni</li></a>
                    <a href="/admin/presta"><li @if(Route::is('admin.presta')) actived @endif><i class="fas fa-truck-loading"></i> Presta un libro</li></a>
                    <a href="/admin/proposte"><li @if(Route::is('admin.proposte')) actived @endif><i class="fa-solid fa-hand-holding-heart"></i> Proposte</li></a>
                    <a href="/admin/completa"><li @if(Route::is('admin.completa')) actived @endif><i class="fas fa-swatchbook"></i> Libri incompleti</li></a>
                    <a href="/admin/bacheca"><li @if(Route::is('admin.bacheca')) actived @endif><i class="fa-solid fa-desktop"></i> Bacheca</li></a>
                </ul>
            </div>
        </div>
        <div class="col-8">
            @yield('admin-content')
        </div>
    </div>
@endsection
@section('script')
    <script src="/js/admin.js"></script>
@endsection
