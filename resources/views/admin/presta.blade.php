@extends('template.admin')
@section('title', 'Presta - Biblioteca')

@section('admin-content')
<form method="POST">
    @csrf
    <presta></presta>
</form>
@endsection
