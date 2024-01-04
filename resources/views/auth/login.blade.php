@extends('template.layout')
@section('title', 'Login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card cc-card" style="border: none;">
                <div class="card-header">{{ __('auth.title') }}</div>
                @error('email')
                <label class="is-invalid-email"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</label>
                @enderror
                <div class="card-body">
                    <div class="col-lg-12 col-10 col-md-10 row" style="margin: 0 auto;text-align: center;">
                        <label style="margin-bottom: 20px;">{{ __("auth.guida") }}</label>
                    </div>
                    <a href="/login/redirect">
                        <div class="google-button col-md-10 col-lg-10 col-12 row">
                            <div class="cc-card btn-card row">
                                <i class="fa-brands fa-google col-2"></i>
                                <p class="col-10">{{ __('auth.google') }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
