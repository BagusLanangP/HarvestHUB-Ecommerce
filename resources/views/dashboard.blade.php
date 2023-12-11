@extends('layouts.mainlayouts')

@section('tittle', 'Dashboard')


@section('content')
    <p>Ini halaman Utama</p>
    <br><br>
    {{ Auth::user()->role }}
@endsection