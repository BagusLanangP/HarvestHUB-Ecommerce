@extends('layouts.mainlayouts')

@section('tittle', 'checkout')

@section('content')

<section class="checkout">
    <div class="row text-center">
        <div class="checkout-tittle">
            <h1>Checkout</h1>
            <h4>Isi data-data terkait untuk melakukan checkout</h4>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-6">
            <h4 class="checkout-subtittle">Identitas alamat</h4>
            <hr>
            <form method="post" action="/" class="mt-4" enctype="multipart/form-data" class="checkout-form">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="namapenerima" class="form-label form-checkout-label">Nama penerima</label>
                            <input type="text" class="form-control"  @error('namapenerima') is-invalid @enderror id="namapenerima" name="namapenerima" required value="{{ old('namapenerima', $itemalamatpengiriman->user->name) }}">
                             @error('namapenerima')
                                  <div class="alert alert-danger">{{ $message }}</div>
                             @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="Telp" class="form-label form-checkout-label">No Telp</label>
                            <input type="text" class="form-control"  @error('Telp') is-invalid @enderror id="Telp" name="Telp" required value="{{ old('Telp', $itemalamatpengiriman->no_tlp) }}">
                             @error('Telp')
                                  <div class="alert alert-danger">{{ $message }}</div>
                             @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="alamat" class="form-label form-checkout-label">Alamat detail</label>
                            <input type="text" class="form-control"  @error('alamat') is-invalid @enderror id="alamat" name="alamat" required value="{{ old('alamat', $itemalamatpengiriman->alamat) }}">
                             @error('alamat')
                                  <div class="alert alert-danger">{{ $message }}</div>
                             @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="kodepos" class="form-label form-checkout-label">Kode Pos</label>
                            <input type="text" class="form-control"  @error('kodepos') is-invalid @enderror id="kodepos" name="kodepos" required value="{{ old('kodepos', $itemalamatpengiriman->no_tlp) }}">
                             @error('kodepos')
                                  <div class="alert alert-danger">{{ $message }}</div>
                             @enderror
                        </div>     
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="kelurahan" class="form-label form-checkout-label">Kelurahan</label>
                            <input type="text" class="form-control"  @error('kelurahan') is-invalid @enderror id="kelurahan" name="kelurahan" required value="{{ old('kelurahan', $itemalamatpengiriman->no_tlp) }}">
                             @error('kelurahan')
                                  <div class="alert alert-danger">{{ $message }}</div>
                             @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="kecamatan" class="form-label form-checkout-label">Kecamatan</label>
                            <input type="text" class="form-control"  @error('kecamatan') is-invalid @enderror id="kecamatan" name="kecamatan" required value="{{ old('kecamatan', $itemalamatpengiriman->no_tlp) }}">
                             @error('kecamatan')
                                  <div class="alert alert-danger">{{ $message }}</div>
                             @enderror
                        </div>
                    </div>
                </div>
               <div class="row">
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="kota" class="form-label form-checkout-label">kota</label>
                            <input type="text" class="form-control"  @error('kota') is-invalid @enderror id="kota" name="kota" required value="{{ old('kota', $itemalamatpengiriman->no_tlp) }}">
                             @error('kota')
                                  <div class="alert alert-danger">{{ $message }}</div>
                             @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="provinsi" class="form-label form-checkout-label">Provinsi</label>
                            <input type="text" class="form-control"  @error('provinsi') is-invalid @enderror id="provinsi" name="provinsi" required value="{{ old('provinsi', $itemalamatpengiriman->no_tlp) }}">
                             @error('provinsi')
                                  <div class="alert alert-danger">{{ $message }}</div>
                             @enderror
                        </div>
                    </div>
               </div>
                  
            </form>
            <div class="row mt-3">
                <div class="col-6">
                    <button type="submit" class="btn submit-login button-checkout d-flex justify-content-center">
                        <a href="{{ URL::to('checkout') }}" class="btn">Edit</a></button>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn submit-login button-checkout d-flex justify-content-center">
                        <a href="{{ URL::to('checkout') }}" class="btn">Simpan</a></button>
                </div>
            </div>
        </div>
        <div class="col-6">
            <h4 class="checkout-subtittle">Struk Nota</h4>
            <hr>
            <div class="nota shadow p-2">
                <div class="row text-center"><h2>{{ $itemcart->no_invoice }}</h2></div>
                <div class="row text-center">
                    <h4>
                        {{ $itemcart->created_at }}
                    </h4>                  
                </div>
                <hr>
                <div class="row">
                    <div class="col-3"><h6>Nama</h6></div>
                    <div class="col-9"><h6>: {{ $itemalamatpengiriman->user->name }}</h6></div>
                </div>
                <div class="row">
                    <div class="col-3"><h6>Telepon</h6></div>
                    <div class="col-9"><h6>: {{ $itemalamatpengiriman->no_tlp }}</h6></div>
                </div>
                <div class="row">
                    <div class="col-3"><h6>Alamat</h6></div>
                    <div class="col-9"><h6>: {{ $itemalamatpengiriman->alamat}}, {{ $itemalamatpengiriman->kelurahan }}</h6></div>
                </div>
                
                <hr>
                <table class="table table-stripped">
                      <thead>
                        <tr>
                          <th>Produk</th>
                          <th>Qty</th>
                          <th>Subtotal</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($itemcart->detail as $produk)
                        <tr>
                            <td>{{ $produk->produk->name }}</td>
                            <td>{{ $produk->qty}}</td>
                            <td>{{ $produk->subtotal }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ $itemcart->total }}</td>
                        </tr>
                      </tbody>
                   
                </table>
                
            </div>
            <div class="row p-2 mt-3">
                <button type="submit" id="buatpesanan" class="btn submit-login d-flex justify-content-center">
                    <form action="{{ route('transaksi.store') }}" method="post">
                        @csrf()
                        Buat Pesanan
                    </form>
                </button>
            </div>
        </div>
    </div>
</section>

@endsection

