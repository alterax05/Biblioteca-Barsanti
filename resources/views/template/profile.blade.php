@extends('template.layout')
@section('title')
    {{ __('profile.profile_of') }} {{ Auth()->user()->name . " " . Auth()->user()->surname }}
@endsection
@section('content')
    <div class="container col-lg-8" style="margin: 0 auto;">
        <div class="row">
            <div class="col-12" style="padding-right: 7px;">
                <div class="welcome cc-card">
                    <p>{{ __('profile.welcome') }} {{ Auth()->user()->name . " " . Auth()->user()->surname }}</p>
                    <p>{{ __('profile.class') }}: {{ Auth()->user()->class }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <div class="cc-card profile-menu" style="overflow: hidden;">
                    <ul>
                        <a href="/profile" class="@if(Route::is('profile.prestiti')) actived @endif"><li><i class="fa-solid fa-rectangle-list"></i> {{ __('profile.in_corso') }}</li></a>
                        <a href="/profile/restituiti" class="@if(Route::is('profile.restituiti')) actived @endif"><li><i class="fa-solid fa-arrow-right-arrow-left"></i> {{ __('profile.returned') }}</li></a>
                        <a href="/profile/preferiti" class="@if(Route::is('profile.preferiti')) actived @endif"><li><i class="fa-solid fa-star"></i> {{ __('profile.favourites') }}</li></a>
                        <a href="/profile/prenotati" class="@if(Route::is('profile.prenotati')) actived @endif"><li><i class="fa-solid fa-calendar-week"></i> {{ __('profile.booked') }}</li></a>
                    </ul>
                </div>
            </div>

            @yield('profile-content')
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
