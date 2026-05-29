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
            <form id="checkout-address-form" class="mt-4 checkout-form">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="namapenerima" class="form-label form-checkout-label">Nama penerima</label>
                            <input type="text" class="form-control"  @error('namapenerima') is-invalid @enderror id="namapenerima" name="namapenerima" required value="{{ old('namapenerima', $itemalamatpengiriman?->user?->name ?? auth()->user()->name) }}">
                             @error('namapenerima')
                                  <div class="alert alert-danger">{{ $message }}</div>
                             @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="Telp" class="form-label form-checkout-label">No Telp</label>
                            <input type="text" class="form-control"  @error('Telp') is-invalid @enderror id="Telp" name="Telp" required value="{{ old('Telp', $itemalamatpengiriman?->no_tlp ?? '') }}">
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
                            <input type="text" class="form-control"  @error('alamat') is-invalid @enderror id="alamat" name="alamat" required value="{{ old('alamat', $itemalamatpengiriman?->alamat ?? '') }}">
                             @error('alamat')
                                  <div class="alert alert-danger">{{ $message }}</div>
                             @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="kodepos" class="form-label form-checkout-label">Kode Pos</label>
                            <input type="text" class="form-control"  @error('kodepos') is-invalid @enderror id="kodepos" name="kodepos" required value="{{ old('kodepos', $itemalamatpengiriman?->kodepos ?? '') }}">
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
                            <input type="text" class="form-control"  @error('kelurahan') is-invalid @enderror id="kelurahan" name="kelurahan" required value="{{ old('kelurahan', $itemalamatpengiriman?->kelurahan ?? '') }}">
                             @error('kelurahan')
                                  <div class="alert alert-danger">{{ $message }}</div>
                             @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="kecamatan" class="form-label form-checkout-label">Kecamatan</label>
                            <input type="text" class="form-control"  @error('kecamatan') is-invalid @enderror id="kecamatan" name="kecamatan" required value="{{ old('kecamatan', $itemalamatpengiriman?->kecamatan ?? '') }}">
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
                            <input type="text" class="form-control"  @error('kota') is-invalid @enderror id="kota" name="kota" required value="{{ old('kota', $itemalamatpengiriman?->kota ?? '') }}">
                             @error('kota')
                                  <div class="alert alert-danger">{{ $message }}</div>
                             @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="provinsi" class="form-label form-checkout-label">Provinsi</label>
                            <input type="text" class="form-control"  @error('provinsi') is-invalid @enderror id="provinsi" name="provinsi" required value="{{ old('provinsi', $itemalamatpengiriman?->provinsi ?? '') }}">
                             @error('provinsi')
                                  <div class="alert alert-danger">{{ $message }}</div>
                             @enderror
                        </div>
                    </div>
               </div>
                  
            </form>
            <div class="row mt-3">
                <div class="col-12">
                    <button type="button" id="save-address-btn" class="btn submit-login button-checkout d-flex justify-content-center w-100">
                        Simpan Alamat
                    </button>
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
                    <div class="col-9"><h6 id="nota-nama">: {{ $itemalamatpengiriman?->user?->name ?? auth()->user()->name }}</h6></div>
                </div>
                <div class="row">
                    <div class="col-3"><h6>Telepon</h6></div>
                    <div class="col-9"><h6 id="nota-telp">: {{ $itemalamatpengiriman?->no_tlp ?? '-' }}</h6></div>
                </div>
                <div class="row">
                    <div class="col-3"><h6>Alamat</h6></div>
                    <div class="col-9"><h6 id="nota-alamat">: {{ $itemalamatpengiriman?->alamat ?? '-' }}, {{ $itemalamatpengiriman?->kelurahan ?? '-' }}</h6></div>
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
                <form action="{{ route('transaksi.store') }}" method="post" class="w-100">
                    @csrf
                    <button type="submit" id="buatpesanan" class="btn submit-login d-flex justify-content-center w-100">
                        Buat Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // reactive updates
        const inputNama = document.getElementById('namapenerima');
        const inputTelp = document.getElementById('Telp');
        const inputAlamat = document.getElementById('alamat');
        const inputKelurahan = document.getElementById('kelurahan');

        const notaNama = document.getElementById('nota-nama');
        const notaTelp = document.getElementById('nota-telp');
        const notaAlamat = document.getElementById('nota-alamat');

        const updateNota = () => {
            notaNama.innerText = ': ' + (inputNama.value || '-');
            notaTelp.innerText = ': ' + (inputTelp.value || '-');
            notaAlamat.innerText = ': ' + (inputAlamat.value || '-') + ', ' + (inputKelurahan.value || '-');
        };

        inputNama.addEventListener('input', updateNota);
        inputTelp.addEventListener('input', updateNota);
        inputAlamat.addEventListener('input', updateNota);
        inputKelurahan.addEventListener('input', updateNota);

        // Save functionality
        document.getElementById('save-address-btn').addEventListener('click', async () => {
            const btn = document.getElementById('save-address-btn');
            btn.innerText = 'Menyimpan...';
            btn.disabled = true;

            const form = document.getElementById('checkout-address-form');
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('{{ route("checkout.alamat.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });
                const result = await response.json();
                if (response.ok && result.success) {
                    alert(result.message);
                } else {
                    alert('Gagal menyimpan alamat. Periksa inputan Anda.');
                    console.error(result);
                }
            } catch (e) {
                console.error(e);
                alert('Terjadi kesalahan.');
            } finally {
                btn.innerText = 'Simpan Alamat';
                btn.disabled = false;
            }
        });
    });
</script>

@endsection

