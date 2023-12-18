<?php

namespace App\Providers;
use App\Models\User;
use App\Models\TenagaKerja;
use App\Models\Konsultan;
use App\Models\Toko;
use Illuminate\Support\Facades\Gate;


use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('tenagaKerja0', function (User $user) {
            $tenagaKerja = TenagaKerja::where('user_id', $user->id)->get();
            $find;

            if ($tenagaKerja->isNotEmpty()) {
                // Data ditemukan, pengguna yang sedang login ada di tabel TenagaKerja
                $find = true;
            } else {
                // Data tidak ditemukan, pengguna yang sedang login tidak ada di tabel TenagaKerja
                $find = false;
            }

            return $user->role_id == 3 && !$find;
            
        });

        Gate::define('tenagaKerja1', function (User $user) {
            $tenagaKerja = TenagaKerja::where('user_id', $user->id)->get();
            $find;

            if ($tenagaKerja->isNotEmpty()) {
                // Data ditemukan, pengguna yang sedang login ada di tabel TenagaKerja
                $find = true;
            } else {
                // Data tidak ditemukan, pengguna yang sedang login tidak ada di tabel TenagaKerja
                $find = false;
            }

            return $user->role_id == 3 && $find;
            
        });
        
        Gate::define('konsultan0', function (User $user) {
            $konsultan = Konsultan::where('user_id', $user->id)->get();
            $find;

            if ($konsultan->isNotEmpty()) {
                // Data ditemukan, pengguna yang sedang login ada di tabel konsultan
                $find = true;
            } else {
                // Data tidak ditemukan, pengguna yang sedang login tidak ada di tabel konsultan
                $find = false;
            }

            return $user->role_id == 4 && !$find;
            
        });

        Gate::define('konsultan1', function (User $user) {
            $konsultan = Konsultan::where('user_id', $user->id)->get();
            $find;

            if ($konsultan->isNotEmpty()) {
                // Data ditemukan, pengguna yang sedang login ada di tabel konsultan
                $find = true;
            } else {
                // Data tidak ditemukan, pengguna yang sedang login tidak ada di tabel konsultan
                $find = false;
            }

            return $user->role_id == 4 && $find;
            
        });

        Gate::define('toko0', function (User $user) {
            $toko = Toko::where('user_id', $user->id)->get();
            $find;

            if ($toko->isNotEmpty()) {
                // Data ditemukan, pengguna yang sedang login ada di tabel konsultan
                $find = true;
            } else {
                // Data tidak ditemukan, pengguna yang sedang login tidak ada di tabel konsultan
                $find = false;
            }

            return $user->role_id == 5 && !$find;
            
        });

        Gate::define('toko1', function (User $user) {
            $toko = Toko::where('user_id', $user->id)->get();
            $find;

            if ($toko->isNotEmpty()) {
                // Data ditemukan, pengguna yang sedang login ada di tabel konsultan
                $find = true;
            } else {
                // Data tidak ditemukan, pengguna yang sedang login tidak ada di tabel konsultan
                $find = false;
            }

            return $user->role_id == 5 && $find;
            
        });

        Gate::define('dashboard', function (User $user) {
           

            return $user->role_id == 5 || $user->role_id == 1;
            
        });

        Gate::define('admin', function (User $user) {
           

            return $user->role_id == 1;
            
        });

    }
}
