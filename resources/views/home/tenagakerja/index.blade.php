@extends('layouts.mainlayouts')

@section('tittle', 'Ahlipakar')


@section('content')
<section class="ahlipakar-page">
    <div class="row">
        <div class="ahlipakar-tittle text-center">
            <h1>Tenaga Kerja Page</h1>
        </div>
    </div>
    <hr>
    <div class="row mb-3">
        @foreach ($data as $d)
            <div class="col-3 mb-3">
                <div class="card me-3 shadow card-product d-flex justify-content-start mb-2">
                    <a href="{{ URL::to('tenagakerja/'.$d->id ) }} ">
                        <img src="{{asset('storage/' . $d->foto)}}" class="card-img-top shadow rounded-circle" alt="...">
                        <div class="card-body">
                            <p class=" text-center review-name mb-0">{{ $d->nama }}</p>
                            <p class="review-desc mb-1 text-center"> {{ $d->keahlian }}</p>
                        </div>
                    </a>
                </div>
            </div>
            @if($loop->iteration % 6 == 0)
                </div><div class="row mb-3">
            @endif
        @endforeach   
       
    </div>

</section>

 
@endsection