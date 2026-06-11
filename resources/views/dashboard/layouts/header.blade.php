<header class="navbar sticky-top flex-md-nowrap p-0 py-2 d-print-none">
    {{-- Branding Logo --}}
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-4 fs-5 text-dark d-flex align-items-center gap-2" href="/">
        <span class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 28px; height: 28px; font-size: 0.95rem;">H</span>
        <span>Harvest<span class="text-success">HUB</span></span>
    </a>
  
    {{-- Mobile Toggles --}}
    <ul class="navbar-nav flex-row d-md-none me-3">
        <li class="nav-item text-nowrap">
            <button class="btn btn-link text-success p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-3"></i>
            </button>
        </li>
    </ul>
  
    {{-- Global Search Bar --}}
    <div class="w-100 px-3 d-none d-md-block">
        <div class="input-group input-group-sm rounded-pill overflow-hidden border border-0" style="max-width: 320px;">
            <span class="input-group-text bg-light border-0 ps-3 text-secondary"><i class="bi bi-search"></i></span>
            <input class="form-control bg-light border-0 py-2" type="text" placeholder="Cari data..." aria-label="Search">
        </div>
    </div>

    @php
        $user = auth()->user();
        $notifications = collect();
        $pendingCount = 0;

        if ($user) {
            if ($user->role_id == 1) {
                // ADMIN NOTIFICATIONS
                // 1. User registrations
                \App\Models\User::with('role')->orderBy('created_at', 'desc')->limit(4)->get()->each(function($u) use ($notifications) {
                    $notifications->push([
                        'icon' => 'bi-person-plus-fill',
                        'color' => 'success',
                        'title' => 'User Baru',
                        'text' => '<strong>' . e($u->name) . '</strong> mendaftar sebagai ' . e($u->role->name ?? 'User') . '.',
                        'time' => $u->created_at,
                        'link' => '/dashboard/user',
                    ]);
                });

                // 2. Role requests
                \App\Models\RoleRequest::with(['user', 'role'])->orderBy('created_at', 'desc')->limit(4)->get()->each(function($rr) use ($notifications) {
                    $statusText = $rr->status == 'pending' ? 'menunggu persetujuan' : ($rr->status == 'approved' ? 'disetujui' : 'ditolak');
                    $statusColor = $rr->status == 'pending' ? 'warning' : ($rr->status == 'approved' ? 'success' : 'danger');
                    $notifications->push([
                        'icon' => 'bi-shield-lock-fill',
                        'color' => $statusColor,
                        'title' => 'Pengajuan Role',
                        'text' => '<strong>' . e($rr->user->name ?? 'User') . '</strong> meminta upgrade ke ' . e($rr->role->name ?? 'Role') . ' (' . $statusText . ').',
                        'time' => $rr->created_at,
                        'link' => route('dashboard.role_requests.index'),
                    ]);
                });

                // 3. Transactions
                \App\Models\Transaction::with('user')->orderBy('created_at', 'desc')->limit(4)->get()->each(function($tx) use ($notifications) {
                    $statusColor = $tx->status == 'Completed' ? 'success' : ($tx->status == 'Pending' ? 'warning' : 'danger');
                    $notifications->push([
                        'icon' => 'bi-wallet2',
                        'color' => $statusColor,
                        'title' => 'Transaksi ' . $tx->status,
                        'text' => 'Transaksi Rp ' . number_format($tx->total_price, 0, ',', '.') . ' oleh ' . e($tx->user->name ?? 'User') . '.',
                        'time' => $tx->created_at,
                        'link' => route('dashboard.analytics.index'),
                    ]);
                });

                // Count pending items
                $pendingCount = \App\Models\RoleRequest::where('status', 'pending')->count() + \App\Models\Transaction::where('status', 'Pending')->count();

            } elseif ($user->role_id == 5) {
                // SELLER NOTIFICATIONS
                $toko = \App\Models\Toko::where('user_id', $user->id)->first();
                if ($toko) {
                    $tokoTransactionIds = \App\Models\Transaction::join('orders', 'transactions.order_id', '=', 'orders.id')
                        ->join('carts', 'orders.cart_id', '=', 'carts.id')
                        ->join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
                        ->join('products', 'cart_details.produk_id', '=', 'products.id')
                        ->where('products.toko_id', $toko->id)
                        ->distinct()
                        ->pluck('transactions.id')
                        ->toArray();

                    \App\Models\Transaction::with('user')
                        ->whereIn('id', $tokoTransactionIds)
                        ->orderBy('created_at', 'desc')
                        ->limit(8)
                        ->get()
                        ->each(function($tx) use ($notifications) {
                            $statusColor = $tx->status == 'Completed' ? 'success' : ($tx->status == 'Pending' ? 'warning' : 'danger');
                            $notifications->push([
                                'icon' => 'bi-cart-fill',
                                'color' => $statusColor,
                                'title' => 'Pesanan ' . $tx->status,
                                'text' => 'Pesanan Rp ' . number_format($tx->total_price, 0, ',', '.') . ' dari ' . e($tx->user->name ?? 'User') . '.',
                                'time' => $tx->created_at,
                                'link' => '/dashboard',
                            ]);
                        });

                    // Count pending orders
                    $pendingCount = \App\Models\Transaction::whereIn('id', $tokoTransactionIds)->where('status', 'Pending')->count();
                }
            }

            // Sort notifications desc by time
            $notifications = $notifications->sortByDesc('time')->take(8);
        }
    @endphp

    {{-- Notification Dropdown --}}
    <div class="dropdown me-3 d-none d-md-block">
        <button class="btn btn-link text-secondary position-relative border-0 p-0 shadow-none" type="button" id="dropdownNotificationMenu" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 1.35rem;">
            <i class="bi bi-bell-fill text-success"></i>
            @if($pendingCount > 0)
                <span class="position-absolute translate-middle badge rounded-pill bg-danger border border-light" style="font-size: 0.65rem; top: 5px; left: calc(100% - 2px); padding: 0.25em 0.5em;">
                    {{ $pendingCount }}
                </span>
            @endif
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-3 py-2" aria-labelledby="dropdownNotificationMenu" style="width: 350px; max-height: 400px; overflow-y: auto;">
            <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
                <span class="fw-bold text-dark" style="font-size: 0.88rem; font-family: 'Outfit', sans-serif;">Pemberitahuan</span>
                @if($pendingCount > 0)
                    <span class="badge bg-danger-subtle text-danger rounded-pill fw-semibold" style="font-size: 0.72rem;">{{ $pendingCount }} Pending</span>
                @endif
            </div>
            
            @if($notifications->isEmpty())
                <div class="text-center py-4 px-3">
                    <i class="bi bi-bell-slash text-muted" style="font-size: 1.8rem;"></i>
                    <p class="text-secondary small mt-2 mb-0">Tidak ada notifikasi baru.</p>
                </div>
            @else
                @foreach($notifications as $notif)
                    <li>
                        <a class="dropdown-item px-3 py-2.5 border-bottom d-flex align-items-start gap-2.5" href="{{ $notif['link'] }}" style="white-space: normal;">
                            <div class="rounded-circle bg-{{ $notif['color'] }}-subtle text-{{ $notif['color'] }} d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; font-size: 0.95rem;">
                                <i class="bi {{ $notif['icon'] }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-0.5">
                                    <span class="fw-bold text-dark" style="font-size: 0.8rem; line-height: 1.2;">{{ $notif['title'] }}</span>
                                    <small class="text-muted" style="font-size: 0.65rem;">{{ $notif['time']->diffForHumans() }}</small>
                                </div>
                                <p class="text-secondary mb-0" style="font-size: 0.75rem; line-height: 1.35;">{!! $notif['text'] !!}</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>

    {{-- Profil Avatar & Menu Dropdown di Kanan --}}
    <div class="dropdown me-4 d-none d-md-block">
        <button class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center gap-2 text-dark border-0 p-0 shadow-none" type="button" id="dropdownUserMenu" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="rounded-circle bg-success text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" style="width: 36px; height: 36px; font-size: 0.95rem;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="text-start">
                <div class="fw-bold small text-dark" style="font-size: 0.82rem; line-height: 1.2;">{{ auth()->user()->name }}</div>
                <small class="text-secondary" style="font-size: 0.72rem;">{{ auth()->user()->role_id == 1 ? 'Administrator' : 'Shop Owner' }}</small>
            </div>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2" aria-labelledby="dropdownUserMenu">
            <li><a class="dropdown-item d-flex align-items-center gap-2" href="/"><i class="bi bi-house-door text-secondary"></i> Beranda Utama</a></li>
            @if(auth()->user()->role_id == 5)
            <li><a class="dropdown-item d-flex align-items-center gap-2" href="/Toko"><i class="bi bi-shop text-secondary"></i> Profil Toko</a></li>
            @endif
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="/logout" method="post" class="m-0">
                    @csrf
                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger"><i class="bi bi-box-arrow-right"></i> Keluar</button>
                </form>
            </li>
        </ul>
    </div>
</header>