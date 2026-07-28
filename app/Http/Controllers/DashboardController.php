<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKategori = Category::count();

        $totalLayanan = Service::count();

        $totalTransaksi = Transaction::count();

        $pendapatan = Transaction::where('payment_status', 'Lunas')
                        ->sum('total');

        return view('dashboard.index', compact(
            'totalKategori',
            'totalLayanan',
            'totalTransaksi',
            'pendapatan'
        ));
    }
}