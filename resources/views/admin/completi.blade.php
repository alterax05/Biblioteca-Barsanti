@extends('template.admin')
@section('title', 'Admin - Biblioteca')

@section('admin-content')
    @foreach($libri as $libro)
        <div class="row cc-card d-flex" style="margin-bottom: 20px; padding: 10px 20px; {!! ($libro->id_libro < 100)? 'background: #b009094f;':'background: #b077094f;' !!}">
            <div class="col-8 align-self-center" style="height: fit-content">
                <p>{{ $libro->titolo }}</p>
                <p style="font-size: 14px">{{ $libro->ISBN }}</p>
            </div>
            <div class="col-4">
                <label style="font-size: 14px; margin-bottom: 10px;">{!! ($libro->id_libro < 100)? '<i class="fas fa-hashtag"></i> Non catalogato':'<i class="fas fa-user"></i> Autore mancante' !!}</label>
                <a href="/admin/book/{{ $libro->ISBN }}/{{ $libro->id_libro }}">
                    <button class="btn btn-primary">Completa</button>
                </a>
            </div>
        </div>
    @endforeach
@endsection
