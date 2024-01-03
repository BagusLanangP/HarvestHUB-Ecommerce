@extends('layouts.mainlayouts')

@section('tittle', 'Ahlipakar')


@section('content')

<div class="detail-ahlipakar">
    <div class="row mt-3">
        <div class="col-6">
            <div class="img-hero-ahlipakar foto-user-service shadow rounded">
                <img src="{{asset('storage/' . $itemproduk->foto)}}" alt="" class="">
            </div>
        </div>
        <div class="col-6">
            <div class="row hero-name-detail-ahlipakar">
                <h1>Hello👋</h1>
                <h1>Saya {{ $itemproduk->nama }} | <span>{{ $itemproduk->keahlian }}</span></h1>
            </div>
            <hr>
            <div class="row deskripsi-ahlipakr-detail">
                <h4>{!! $itemproduk->deskripsi !!}</h4>
            </div>
            <hr>
            <div class="row">
                <h6>{!! $itemproduk->pengalaman !!}</h6>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-6">
            <button type="submit" class="btn submit-login d-flex justify-content-center download-ahlipakar">
                <a href="{{ URL::to('checkout') }}" class="btn">Download CV</a></button>
        </div>
        <div class="col-6">
            <button type="submit" class="btn submit-login d-flex justify-content-center chat-ahlipakar">
                <a href="https://wa.me/{{ $itemproduk->phone }}" class="btn">Chat</a></button>
        </div>
    </div>
</div>


@endsection