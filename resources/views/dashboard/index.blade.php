@extends('dashboard.layouts.main')

@section('container')

@php
    $user = auth()->user();
@endphp

{{-- ========================================================================= --}}
{{-- 1. SUPER ADMIN INTERFACE (ROLE ID == 1) --}}
{{-- ========================================================================= --}}
@if($user->role_id == 1)
    
    @php
        // Fetch Admin Eager Metrics
        $totalUsers = \App\Models\User::count();
        $globalProducts = \App\Models\Product::count();
        $globalTransactions = \App\Models\Transaction::count();
        $globalRevenue = \App\Models\Transaction::where('status', 'Completed')->sum('total_price') ?: 0;
        
        $totalTenagaKerja = \App\Models\TenagaKerja::count();
        $totalKonsultan = \App\Models\Konsultan::count();
        
        // Eager load listings
        $recentGlobalProducts = \App\Models\Product::with('kategori')->orderBy('created_at', 'desc')->limit(3)->get();
        $pendingRoleRequests = \App\Models\RoleRequest::with(['user', 'role'])
                                ->where('status', 'pending')
                                ->orderBy('created_at', 'desc')
                                ->limit(3)
                                ->get();
        $recentTenagaKerja = \App\Models\TenagaKerja::orderBy('created_at', 'desc')->limit(3)->get();
        $recentKonsultan = \App\Models\Konsultan::orderBy('created_at', 'desc')->limit(3)->get();
    @endphp

    <div class="py-4">
        
        {{-- Super Admin Welcome Banner --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-banner p-4 p-sm-5 rounded-4 position-relative overflow-hidden text-white shadow-sm" style="background: linear-gradient(135deg, #0d6efd 0%, #1e3d59 100%);">
                    <div class="position-absolute rounded-circle opacity-10 bg-white" style="width: 250px; height: 250px; right: -50px; top: -50px;"></div>
                    <div class="position-absolute rounded-circle opacity-10 bg-white" style="width: 150px; height: 150px; right: 150px; bottom: -50px;"></div>
                    
                    <div class="position-relative z-1">
                        <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-3 py-1.5 mb-3 fw-semibold small" style="backdrop-filter: blur(4px);">
                            Super Admin Control Panel
                        </span>
                        <h2 class="fw-bold tracking-tight mb-2" style="font-family: 'Outfit', sans-serif; font-size: 1.85rem;">
                            Selamat Datang, {{ $user->name }}! 👑
                        </h2>
                        <p class="mb-0 opacity-85 small leading-relaxed col-lg-8 ps-0">
                            Kelola operasional ekosistem HarvestHUB secara menyeluruh. Anda memiliki kendali penuh atas akun pengguna, antrean upgrade role, katalog produk global, serta laporan analitis finansial platform.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- 6 Columns Metrics Grid for Admin --}}
        <div class="row g-3 mb-5">
            {{-- Card 1: Total Pengguna --}}
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card border-0 shadow-xs rounded-4 p-3.5 metric-card bg-white d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px;">
                        <i class="bi bi-people-fill" style="font-size: 1.2rem;"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase tracking-wider" style="font-size: 0.68rem; display: block; line-height: 1;">Total User</span>
                        <h5 class="fw-bold text-dark mb-0 mt-1" style="font-family: 'Outfit', sans-serif;">{{ $totalUsers }}</h5>
                    </div>
                </div>
            </div>

            {{-- Card 2: Total Produk Global --}}
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card border-0 shadow-xs rounded-4 p-3.5 metric-card bg-white d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px;">
                        <i class="bi bi-box-seam-fill" style="font-size: 1.2rem;"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase tracking-wider" style="font-size: 0.68rem; display: block; line-height: 1;">Total Produk</span>
                        <h5 class="fw-bold text-dark mb-0 mt-1" style="font-family: 'Outfit', sans-serif;">{{ $globalProducts }}</h5>
                    </div>
                </div>
            </div>

            {{-- Card 3: Total Transaksi Global --}}
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card border-0 shadow-xs rounded-4 p-3.5 metric-card bg-white d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px;">
                        <i class="bi bi-bag-check-fill" style="font-size: 1.2rem;"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase tracking-wider" style="font-size: 0.68rem; display: block; line-height: 1;">Transaksi</span>
                        <h5 class="fw-bold text-dark mb-0 mt-1" style="font-family: 'Outfit', sans-serif;">{{ $globalTransactions }}</h5>
                    </div>
                </div>
            </div>

            {{-- Card 4: Tenaga Kerja --}}
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card border-0 shadow-xs rounded-4 p-3.5 metric-card bg-white d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px;">
                        <i class="bi bi-tools" style="font-size: 1.2rem;"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase tracking-wider" style="font-size: 0.68rem; display: block; line-height: 1;">Tenaga Kerja</span>
                        <h5 class="fw-bold text-dark mb-0 mt-1" style="font-family: 'Outfit', sans-serif;">{{ $totalTenagaKerja }}</h5>
                    </div>
                </div>
            </div>

            {{-- Card 5: Ahli Pakar --}}
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card border-0 shadow-xs rounded-4 p-3.5 metric-card bg-white d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px;">
                        <i class="bi bi-mortarboard-fill" style="font-size: 1.2rem;"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase tracking-wider" style="font-size: 0.68rem; display: block; line-height: 1;">Ahli Pakar</span>
                        <h5 class="fw-bold text-dark mb-0 mt-1" style="font-family: 'Outfit', sans-serif;">{{ $totalKonsultan }}</h5>
                    </div>
                </div>
            </div>

            {{-- Card 6: Total Pendapatan Global --}}
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card border-0 shadow-xs rounded-4 p-3.5 metric-card bg-white d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle bg-dark-subtle text-dark d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px;">
                        <i class="bi bi-wallet2" style="font-size: 1.2rem;"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase tracking-wider" style="font-size: 0.68rem; display: block; line-height: 1;">Pendapatan</span>
                        <h5 class="fw-bold text-success mb-0 mt-1 text-truncate" style="font-family: 'Outfit', sans-serif; font-size: 0.95rem; letter-spacing: -0.5px;" title="Rp {{ number_format($globalRevenue, 0, ',', '.') }}">
                            Rp{{ number_format($globalRevenue, 0, ',', '.') }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- Admin Quick Actions --}}
        <div class="row mb-5">
            <div class="col-12">
                <h6 class="fw-bold text-dark text-uppercase tracking-wider small mb-3" style="font-family: 'Outfit', sans-serif;"><i class="bi bi-lightning-charge-fill text-primary me-1"></i> Aksi Cepat Administrator</h6>
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <a href="/dashboard/user" class="text-decoration-none">
                            <div class="card p-3 border-0 shadow-xs text-center quick-action-card h-100 justify-content-center">
                                <div class="rounded-circle bg-primary-subtle text-primary mx-auto d-flex align-items-center justify-content-center mb-2" style="width: 45px; height: 45px;">
                                    <i class="bi bi-people" style="font-size: 1.2rem;"></i>
                                </div>
                                <span class="fw-bold text-dark small">Kelola Pengguna</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('dashboard.role_requests.index') }}" class="text-decoration-none">
                            <div class="card p-3 border-0 shadow-xs text-center quick-action-card h-100 justify-content-center">
                                <div class="rounded-circle bg-success-subtle text-success mx-auto d-flex align-items-center justify-content-center mb-2" style="width: 45px; height: 45px;">
                                    <i class="bi bi-shield-lock" style="font-size: 1.2rem;"></i>
                                </div>
                                <span class="fw-bold text-dark small">Pengajuan Role</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('dashboard.analytics.index') }}" class="text-decoration-none">
                            <div class="card p-3 border-0 shadow-xs text-center quick-action-card h-100 justify-content-center">
                                <div class="rounded-circle bg-warning-subtle text-warning mx-auto d-flex align-items-center justify-content-center mb-2" style="width: 45px; height: 45px;">
                                    <i class="bi bi-graph-up" style="font-size: 1.2rem;"></i>
                                </div>
                                <span class="fw-bold text-dark small">Analitis Finansial</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="/" class="text-decoration-none">
                            <div class="card p-3 border-0 shadow-xs text-center quick-action-card h-100 justify-content-center">
                                <div class="rounded-circle bg-secondary-subtle text-secondary mx-auto d-flex align-items-center justify-content-center mb-2" style="width: 45px; height: 45px;">
                                    <i class="bi bi-house-door" style="font-size: 1.2rem;"></i>
                                </div>
                                <span class="fw-bold text-dark small">Kembali ke Toko</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Admin Dual Listing Panels (Products & Role Requests) --}}
        <div class="row g-4 mb-4">
            
            {{-- Left Panel: Global Products --}}
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0" style="font-family: 'Outfit', sans-serif;"><i class="bi bi-box me-1 text-success"></i> Katalog Terbaru Global</h5>
                        <a href="/dashboard/product" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-semibold small" style="font-size: 0.78rem;">Semua</a>
                    </div>

                    @if($recentGlobalProducts->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-box-seam text-muted" style="font-size: 2rem;"></i>
                            <p class="text-secondary small mt-2 mb-0">Belum ada produk global.</p>
                        </div>
                    @else
                        <div class="table-responsive small">
                            <table class="table mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th class="ps-0 text-secondary">Produk</th>
                                        <th class="text-secondary text-end">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentGlobalProducts as $prod)
                                    <tr>
                                        <td class="ps-0 py-2">
                                            <div class="d-flex align-items-center gap-2.5">
                                                <img src="{{ $prod->image_url }}" alt="" class="rounded shadow-xs border" style="width: 40px; height: 40px; object-fit: cover;">
                                                <div>
                                                    <span class="product-name text-dark d-block" style="font-size: 0.86rem;">{{ $prod->name }}</span>
                                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $prod->kategori->productName ?? 'Kategori' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-2 text-end text-success fw-semibold" style="font-size: 0.85rem;">Rp {{ number_format($prod->harga, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right Panel: Eager Pending Role Requests --}}
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0" style="font-family: 'Outfit', sans-serif;"><i class="bi bi-shield-lock me-1 text-primary"></i> Antrean Upgrade Role</h5>
                        <a href="{{ route('dashboard.role_requests.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold small" style="font-size: 0.78rem;">Semua</a>
                    </div>

                    @if($pendingRoleRequests->isEmpty())
                        <div class="text-center py-5">
                            <div class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                <i class="bi bi-check-circle" style="font-size: 1.5rem;"></i>
                            </div>
                            <p class="text-secondary small fw-medium mt-1 mb-0">Antrean bersih! Tidak ada pengajuan pending.</p>
                        </div>
                    @else
                        <div class="table-responsive small">
                            <table class="table mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th class="ps-0 text-secondary">Pengaju</th>
                                        <th class="text-secondary text-center">Peran</th>
                                        <th class="pe-0 text-secondary text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingRoleRequests as $req)
                                    <tr>
                                        <td class="ps-0 py-2">
                                            <div>
                                                <span class="text-dark fw-bold d-block" style="font-size: 0.86rem;">{{ $req->user->name }}</span>
                                                <small class="text-muted" style="font-size: 0.7rem;">{{ $req->user->email }}</small>
                                            </div>
                                        </td>
                                        <td class="py-2 text-center">
                                            <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1 fw-semibold" style="font-size: 0.72rem;">
                                                {{ $req->role->name }}
                                            </span>
                                        </td>
                                        <td class="pe-0 py-2 text-end">
                                            <div class="d-flex justify-content-end gap-1.5">
                                                <a href="{{ route('dashboard.role_requests.show', $req->id) }}" class="btn btn-sm btn-primary rounded-pill px-2.5 py-1 small fw-semibold text-white" style="font-size: 0.72rem;">Detail</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- Admin Service Listing Panels (Tenaga Kerja & Ahli Pakar) --}}
        <div class="row g-4">
            
            {{-- Left Panel: Active Tenaga Kerja --}}
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0" style="font-family: 'Outfit', sans-serif;"><i class="bi bi-tools me-1 text-info"></i> Tenaga Kerja Tersedia</h5>
                        <a href="/Tenagakerja/view" class="btn btn-outline-info btn-sm rounded-pill px-3 fw-semibold small" style="font-size: 0.78rem;">Lihat Publik</a>
                    </div>

                    @if($recentTenagaKerja->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-person-exclamation text-muted" style="font-size: 2rem;"></i>
                            <p class="text-secondary small mt-2 mb-0">Belum ada penyedia jasa terdaftar.</p>
                        </div>
                    @else
                        <div class="table-responsive small">
                            <table class="table mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th class="ps-0 text-secondary">Penyedia Jasa</th>
                                        <th class="text-secondary">Keterampilan</th>
                                        <th class="pe-0 text-secondary text-end">Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTenagaKerja as $tk)
                                    <tr>
                                        <td class="ps-0 py-2">
                                            <div class="d-flex align-items-center gap-2.5">
                                                <img src="{{ $tk->foto ? asset('storage/' . $tk->foto) : asset('img/default-avatar.png') }}" alt="" class="rounded-circle shadow-xs border" style="width: 35px; height: 35px; object-fit: cover;">
                                                <div>
                                                    <span class="text-dark fw-bold d-block" style="font-size: 0.86rem;">{{ $tk->nama }}</span>
                                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $tk->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-2">
                                            <span class="badge bg-info-subtle text-info rounded-pill px-2.5 py-1 fw-semibold" style="font-size: 0.72rem;">
                                                {{ Str::limit($tk->keahlian, 20) }}
                                            </span>
                                        </td>
                                        <td class="pe-0 py-2 text-end text-secondary" style="font-size: 0.8rem;">
                                            {{ Str::limit($tk->alamat, 25) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right Panel: Active Ahli Pakar --}}
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0" style="font-family: 'Outfit', sans-serif;"><i class="bi bi-mortarboard-fill me-1 text-danger"></i> Konsultan & Ahli Pakar</h5>
                        <a href="/Ahlipakar/view" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-semibold small" style="font-size: 0.78rem;">Lihat Publik</a>
                    </div>

                    @if($recentKonsultan->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-person-exclamation text-muted" style="font-size: 2rem;"></i>
                            <p class="text-secondary small mt-2 mb-0">Belum ada pakar terdaftar.</p>
                        </div>
                    @else
                        <div class="table-responsive small">
                            <table class="table mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th class="ps-0 text-secondary">Konsultan</th>
                                        <th class="text-secondary">Spesialisasi</th>
                                        <th class="pe-0 text-secondary text-end">Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentKonsultan as $ks)
                                    <tr>
                                        <td class="ps-0 py-2">
                                            <div class="d-flex align-items-center gap-2.5">
                                                <img src="{{ $ks->foto ? asset('storage/' . $ks->foto) : asset('img/default-avatar.png') }}" alt="" class="rounded-circle shadow-xs border" style="width: 35px; height: 35px; object-fit: cover;">
                                                <div>
                                                    <span class="text-dark fw-bold d-block" style="font-size: 0.86rem;">{{ $ks->nama }}</span>
                                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $ks->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-2">
                                            <span class="badge bg-danger-subtle text-danger rounded-pill px-2.5 py-1 fw-semibold" style="font-size: 0.72rem;">
                                                {{ Str::limit($ks->keahlian, 20) }}
                                            </span>
                                        </td>
                                        <td class="pe-0 py-2 text-end text-secondary" style="font-size: 0.8rem;">
                                            {{ Str::limit($ks->alamat, 25) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

{{-- ========================================================================= --}}
{{-- 2. SELLER / SHOP OWNER INTERFACE (ROLE ID == 5) --}}
{{-- ========================================================================= --}}
@else
    
    @php
        // Fetch Shop Specific Metrics
        $toko = \App\Models\Toko::where('user_id', $user->id)->first();
        
        $tokoProductCount = 0;
        $tokoTransactionCount = 0;
        $tokoSalesQty = 0;
        $recentTokoProducts = collect();
        $recentTokoOrders = collect();
        
        if ($toko) {
            $tokoProductCount = \App\Models\Product::where('toko_id', $toko->id)->count();
            
            // Unique transaction IDs for this shop to prevent MySQL ONLY_FULL_GROUP_BY issues
            $tokoTransactionIds = \App\Models\Transaction::join('orders', 'transactions.order_id', '=', 'orders.id')
                ->join('carts', 'orders.cart_id', '=', 'carts.id')
                ->join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
                ->join('products', 'cart_details.produk_id', '=', 'products.id')
                ->where('products.toko_id', $toko->id)
                ->distinct()
                ->pluck('transactions.id')
                ->toArray();
                
            $tokoTransactionCount = count($tokoTransactionIds);
                
            // Sum quantities of completed transactions
            $tokoSalesQty = \App\Models\Transaction::join('orders', 'transactions.order_id', '=', 'orders.id')
                ->join('carts', 'orders.cart_id', '=', 'carts.id')
                ->join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
                ->join('products', 'cart_details.produk_id', '=', 'products.id')
                ->where('products.toko_id', $toko->id)
                ->where('transactions.status', 'Completed')
                ->sum('cart_details.qty') ?: 0;
                
            // Recent Products
            $recentTokoProducts = \App\Models\Product::with('kategori')
                                ->where('toko_id', $toko->id)
                                ->orderBy('created_at', 'desc')
                                ->limit(3)
                                ->get();
                                
            // Recent incoming orders fetched safely using whereIn and eager loading relation
            $recentTokoOrders = \App\Models\Transaction::with('order')
                ->whereIn('id', $tokoTransactionIds)
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
        }
    @endphp

    <div class="py-4">
        
        {{-- Seller / Shop Owner Welcome Banner --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-banner p-4 p-sm-5 rounded-4 position-relative overflow-hidden text-white shadow-sm" style="background: linear-gradient(135deg, #198754 0%, #2c4d3d 100%);">
                    <div class="position-absolute rounded-circle opacity-10 bg-white" style="width: 250px; height: 250px; right: -50px; top: -50px;"></div>
                    <div class="position-absolute rounded-circle opacity-10 bg-white" style="width: 150px; height: 150px; right: 150px; bottom: -50px;"></div>
                    
                    <div class="position-relative z-1">
                        <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-3 py-1.5 mb-3 fw-semibold small" style="backdrop-filter: blur(4px);">
                            Shop Owner Seller Center
                        </span>
                        <h2 class="fw-bold tracking-tight mb-2" style="font-family: 'Outfit', sans-serif; font-size: 1.85rem;">
                            Selamat Datang di Seller Panel, {{ $user->name }}! 🚜
                        </h2>
                        <p class="mb-0 opacity-85 small leading-relaxed col-lg-8 ps-0">
                            Kelola toko Anda dengan mudah! Tambah produk hasil tani segar, kelola stok katalog produk, dan pantau status transaksi penjualan toko Anda di platform HarvestHUB.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3 Columns Metrics Grid for Seller --}}
        <div class="row g-4 mb-5">
            {{-- Card 1: Total Produk Toko --}}
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-xs rounded-4 p-4 metric-card bg-white d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center flex-shrink-0" style="width: 60px; height: 60px;">
                        <i class="bi bi-box-seam-fill" style="font-size: 1.6rem;"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase tracking-wider">Katalog Produk</span>
                        <h3 class="fw-bold text-dark mb-0 mt-0.5" style="font-family: 'Outfit', sans-serif; font-size: 1.7rem;">{{ $tokoProductCount }}</h3>
                        <small class="text-muted" style="font-size: 0.75rem;">Item toko terdaftar</small>
                    </div>
                </div>
            </div>

            {{-- Card 2: Total Pesanan Toko --}}
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-xs rounded-4 p-4 metric-card bg-white d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center flex-shrink-0" style="width: 60px; height: 60px;">
                        <i class="bi bi-bag-check-fill" style="font-size: 1.6rem;"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase tracking-wider">Pesanan Toko</span>
                        <h3 class="fw-bold text-dark mb-0 mt-0.5" style="font-family: 'Outfit', sans-serif; font-size: 1.7rem;">{{ $tokoTransactionCount }}</h3>
                        <small class="text-muted" style="font-size: 0.75rem;">Total order masuk</small>
                    </div>
                </div>
            </div>

            {{-- Card 3: Volume Terjual --}}
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-xs rounded-4 p-4 metric-card bg-white d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center flex-shrink-0" style="width: 60px; height: 60px;">
                        <i class="bi bi-basket3-fill" style="font-size: 1.6rem;"></i>
                    </div>
                    <div>
                        <span class="text-secondary small fw-semibold text-uppercase tracking-wider">Hasil Tani Terjual</span>
                        <h3 class="fw-bold text-dark mb-0 mt-0.5" style="font-family: 'Outfit', sans-serif; font-size: 1.7rem;">{{ $tokoSalesQty }} pcs</h3>
                        <small class="text-muted" style="font-size: 0.75rem;">Produk sukses disalurkan</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Seller Quick Actions --}}
        <div class="row mb-5">
            <div class="col-12">
                <h6 class="fw-bold text-dark text-uppercase tracking-wider small mb-3" style="font-family: 'Outfit', sans-serif;"><i class="bi bi-lightning-charge-fill text-success me-1"></i> Aksi Cepat Toko</h6>
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <a href="/dashboard/product/create" class="text-decoration-none">
                            <div class="card p-3 border-0 shadow-xs text-center quick-action-card h-100 justify-content-center">
                                <div class="rounded-circle bg-success-subtle text-success mx-auto d-flex align-items-center justify-content-center mb-2" style="width: 45px; height: 45px;">
                                    <i class="bi bi-plus-circle" style="font-size: 1.2rem;"></i>
                                </div>
                                <span class="fw-bold text-dark small">Tambah Produk</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="/Toko" class="text-decoration-none">
                            <div class="card p-3 border-0 shadow-xs text-center quick-action-card h-100 justify-content-center">
                                <div class="rounded-circle bg-info-subtle text-info mx-auto d-flex align-items-center justify-content-center mb-2" style="width: 45px; height: 45px;">
                                    <i class="bi bi-shop" style="font-size: 1.2rem;"></i>
                                </div>
                                <span class="fw-bold text-dark small">Profil Toko</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="/dashboard/product" class="text-decoration-none">
                            <div class="card p-3 border-0 shadow-xs text-center quick-action-card h-100 justify-content-center">
                                <div class="rounded-circle bg-warning-subtle text-warning mx-auto d-flex align-items-center justify-content-center mb-2" style="width: 45px; height: 45px;">
                                    <i class="bi bi-card-checklist" style="font-size: 1.2rem;"></i>
                                </div>
                                <span class="fw-bold text-dark small">Daftar Katalog</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="/" class="text-decoration-none">
                            <div class="card p-3 border-0 shadow-xs text-center quick-action-card h-100 justify-content-center">
                                <div class="rounded-circle bg-secondary-subtle text-secondary mx-auto d-flex align-items-center justify-content-center mb-2" style="width: 45px; height: 45px;">
                                    <i class="bi bi-house-door" style="font-size: 1.2rem;"></i>
                                </div>
                                <span class="fw-bold text-dark small">Beranda E-Store</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Seller Dual Panels --}}
        <div class="row g-4">
            {{-- Left Panel: Shop Products --}}
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0" style="font-family: 'Outfit', sans-serif;"><i class="bi bi-box me-1 text-success"></i> Katalog Toko Terbaru</h5>
                        <a href="/dashboard/product" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-semibold small" style="font-size: 0.78rem;">Semua</a>
                    </div>

                    @if($recentTokoProducts->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-box-seam text-muted" style="font-size: 2rem;"></i>
                            <p class="text-secondary small mt-2 mb-0">Belum ada katalog produk di toko Anda.</p>
                        </div>
                    @else
                        <div class="table-responsive small">
                            <table class="table mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th class="ps-0 text-secondary">Produk</th>
                                        <th class="text-secondary text-end">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTokoProducts as $prod)
                                    <tr>
                                        <td class="ps-0 py-2">
                                            <div class="d-flex align-items-center gap-2.5">
                                                <img src="{{ $prod->image_url }}" alt="" class="rounded shadow-xs border" style="width: 40px; height: 40px; object-fit: cover;">
                                                <div>
                                                    <span class="product-name text-dark d-block" style="font-size: 0.86rem;">{{ $prod->name }}</span>
                                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $prod->kategori->productName ?? 'Kategori' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-2 text-end text-success fw-semibold" style="font-size: 0.85rem;">Rp {{ number_format($prod->harga, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right Panel: Incoming Orders containing products from this store --}}
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0" style="font-family: 'Outfit', sans-serif;"><i class="bi bi-bag me-1 text-success"></i> Pesanan Masuk Terbaru</h5>
                        <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1.5 fw-semibold small" style="font-size: 0.72rem;">Aktif</span>
                    </div>

                    @if($recentTokoOrders->isEmpty())
                        <div class="text-center py-5">
                            <div class="rounded-circle bg-light text-muted d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                <i class="bi bi-cart-x" style="font-size: 1.5rem;"></i>
                            </div>
                            <p class="text-secondary small fw-medium mt-1 mb-0">Belum ada pesanan masuk untuk toko Anda.</p>
                        </div>
                    @else
                        <div class="table-responsive small">
                            <table class="table mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th class="ps-0 text-secondary">Tanggal</th>
                                        <th class="text-secondary text-center">Penerima</th>
                                        <th class="pe-0 text-secondary text-end">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTokoOrders as $order)
                                    <tr>
                                        <td class="ps-0 py-2">
                                            <div>
                                                <span class="text-dark fw-bold d-block" style="font-size: 0.86rem;">{{ $order->created_at->format('d M Y') }}</span>
                                                <small class="text-muted" style="font-size: 0.7rem;">{{ $order->created_at->format('H:i') }} WITA</small>
                                            </div>
                                        </td>
                                        <td class="py-2 text-center text-dark fw-medium" style="font-size: 0.84rem;">
                                            {{ $order->order->nama_penerima ?? $order->nama_penerima ?? 'Pembeli' }}
                                        </td>
                                        <td class="pe-0 py-2 text-end">
                                            <span class="badge rounded-pill px-2.5 py-1.5 fw-semibold small d-inline-flex align-items-center gap-1
                                                {{ $order->status == 'Completed' ? 'bg-success text-white' : ($order->status == 'Pending' ? 'bg-warning text-dark' : 'bg-danger text-white') }}" style="font-size: 0.72rem;">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

@endif

@endsection