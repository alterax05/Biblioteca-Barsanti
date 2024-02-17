@extends('template.admin')
@section('title', 'Presta - Biblioteca')

@section('admin-content')
<form method="POST">
    @csrf
    <Presta />
</form>
@endsection
