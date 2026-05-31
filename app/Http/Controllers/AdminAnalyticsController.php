<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'monthly'); // daily, weekly, monthly

        $startDate = Carbon::now();
        if ($period === 'daily') {
            $startDate = Carbon::today();
            $label = 'Hari Ini';
        } elseif ($period === 'weekly') {
            $startDate = Carbon::now()->startOfWeek();
            $label = 'Minggu Ini';
        } else {
            $startDate = Carbon::now()->startOfMonth();
            $label = 'Bulan Ini';
        }

        $newRegistrations = User::where('created_at', '>=', $startDate)->count();

        $transactionVolume = Transaction::where('status', 'Completed')
                                        ->where('created_at', '>=', $startDate)
                                        ->sum('total_price');

        $transactionCount = Transaction::where('status', 'Completed')
                                       ->where('created_at', '>=', $startDate)
                                       ->count();

        return view('dashboard.analytics.index', compact('newRegistrations', 'transactionVolume', 'transactionCount', 'period', 'label'));
    }
}
