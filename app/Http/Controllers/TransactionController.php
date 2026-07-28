<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    /**
     * Menampilkan halaman transaksi.
     */
    public function index()
    {
        $services = Service::with('category')->get();

        return view('transactions.index', compact('services'));
    }

    /**
     * Menambahkan layanan ke keranjang (Session).
     */
    public function addToCart(Service $service)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$service->id])) {

            $cart[$service->id]['qty']++;

            $cart[$service->id]['subtotal'] =
                $cart[$service->id]['qty'] * $cart[$service->id]['price'];

        } else {

            $cart[$service->id] = [

                'service_id' => $service->id,
                'name'       => $service->name,
                'price'      => $service->price,
                'qty'        => 1,
                'subtotal'   => $service->price,

            ];
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Layanan berhasil ditambahkan ke keranjang.');
    }
    /**
 * Menambah jumlah layanan di keranjang.
 */
public function increaseQty(Service $service)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$service->id])) {

        $cart[$service->id]['qty']++;

        $cart[$service->id]['subtotal'] =
            $cart[$service->id]['qty'] *
            $cart[$service->id]['price'];

        session()->put('cart', $cart);
    }

    return back();
}

/**
 * Mengurangi jumlah layanan di keranjang.
 */
public function decreaseQty(Service $service)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$service->id])) {

        if ($cart[$service->id]['qty'] > 1) {

            $cart[$service->id]['qty']--;

            $cart[$service->id]['subtotal'] =
                $cart[$service->id]['qty'] *
                $cart[$service->id]['price'];

        } else {

            unset($cart[$service->id]);

        }

        session()->put('cart', $cart);
    }

    return back();
}

public function updateQty(Request $request, Service $service)
{
    $request->validate([
        'qty' => 'required|integer|min:1'
    ]);

    $cart = session()->get('cart', []);

    if (isset($cart[$service->id])) {

        $cart[$service->id]['qty'] = $request->qty;

        $cart[$service->id]['subtotal'] =
            $request->qty * $cart[$service->id]['price'];

        session()->put('cart', $cart);
    }

    return back();
}

/**
 * Menghapus satu layanan dari keranjang.
 */
public function removeCart(Service $service)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$service->id])) {

        unset($cart[$service->id]);

        session()->put('cart', $cart);
    }

    return back();
}

/**
 * Mengosongkan seluruh keranjang.
 */
public function clearCart()
{
    session()->forget('cart');

    return back()->with(
        'success',
        'Keranjang berhasil dikosongkan.'
    );
}

    /**
     * Menyimpan transaksi.
     */
   public function store(Request $request)
{
    // ============================
    // Validasi
    // ============================
    $request->validate([
        'customer_name'  => 'required|string|max:100',
        'notes'          => 'nullable|string|max:500',
        'payment_method' => 'nullable|string',
        'amount'         => 'nullable|numeric|min:0',
        'total'          => 'required|numeric|min:0',
    ]);

    // ============================
    // Keranjang
    // ============================
    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return back()->with('error', 'Keranjang masih kosong.');
    }

    $amount = $request->amount ?? 0;

    $invoice = 'INV-' . now()->format('YmdHis');

    DB::transaction(function () use ($request, $cart, $amount, $invoice) {

        // ============================
        // Cari piutang pelanggan
        // ============================
        $transaction = Transaction::where('customer_name', $request->customer_name)
            ->where('payment_status', 'Belum Lunas')
            ->latest()
            ->first();

        // ============================
        // Kalau belum ada piutang
        // ============================
        if (!$transaction) {

            $transaction = Transaction::create([

                'invoice' => $invoice,

                'customer_name' => $request->customer_name,

                'total' => $request->total,

                'payment_status' => 'Belum Lunas',

                'transaction_date' => now(),

                'notes' => $request->notes,

            ]);

        }

        // ============================
        // Kalau sudah ada piutang
        // ============================
        else {

            $catatan = $transaction->notes;

            if ($request->filled('notes')) {

                if (!empty($catatan)) {

                    $catatan .= "\n\n---------------------------------\n";

                }

                $catatan .= "[" . now()->format('d-m-Y H:i') . "]\n";

                $catatan .= $request->notes;

            }

            $transaction->update([

                'total' => $transaction->total + $request->total,

                'notes' => $catatan,

            ]);

        }

        // ============================
        // Simpan detail transaksi
        // ============================
        foreach ($cart as $item) {

            TransactionDetail::create([

                'transaction_id' => $transaction->id,

                'service_id' => $item['service_id'],

                'qty' => $item['qty'],

                'price' => $item['price'],

                'subtotal' => $item['subtotal'],

            ]);

        }

        // ============================
        // Simpan pembayaran awal
        // ============================
        if ($amount > 0) {

            Payment::create([

                'transaction_id' => $transaction->id,

                'amount' => $amount,

                'payment_method' => $request->payment_method,

                'payment_date' => now(),

                'notes' => $request->notes,

            ]);

        }

        // ============================
        // Update status pembayaran
        // ============================
        $totalBayar = $transaction->payments()->sum('amount');

        $transaction->update([

            'payment_status' => $totalBayar >= $transaction->total
                ? 'Lunas'
                : 'Belum Lunas'

        ]);

    });

    session()->forget('cart');

    return redirect()
        ->route('transactions.index')
        ->with('success', 'Transaksi berhasil disimpan.');
}

    /**
     * Form tambah transaksi.
     */
    public function create()
    {
        //
    }

    /**
     * Detail transaksi.
     */
    
public function show(Transaction $transaction)
{
    $transaction->load([
        'details.service',
        'payments'
    ]);

    return view('transactions.show', compact('transaction'));
}

    /**
     * Form edit transaksi.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update transaksi.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    public function addPayment(Request $request, Transaction $transaction)
{
    $request->validate([
        'amount' => 'required|numeric|min:1',
        'payment_method' => 'required'
    ]);
    $totalBayar = $transaction->payments()->sum('amount');

if ($totalBayar >= $transaction->total) {

    $transaction->update([
        'payment_status' => 'Lunas'
    ]);

} else {

    $transaction->update([
        'payment_status' => 'Belum Lunas'
    ]);

}

$sisa = $transaction->total - $totalBayar;

if ($request->amount > $sisa) {

    return back()->with(
        'error',
        'Nominal pembayaran melebihi sisa tagihan.'
    );

}

    Payment::create([

        'transaction_id' => $transaction->id,

        'amount' => $request->amount,

        'payment_method' => $request->payment_method,

        'payment_date' => now(),

        'notes' => null,

    ]);

    $totalBayar = $transaction->payments()->sum('amount');

    if ($totalBayar >= $transaction->total) {

        $transaction->update([

            'payment_status' => 'Lunas'

        ]);

    }

    return back()->with(
        'success',
        'Pembayaran berhasil ditambahkan.'
    );
}/**
     * Hapus transaksi.
     */
   public function destroy(Transaction $transaction)
{
    DB::transaction(function () use ($transaction) {

        $transaction->payments()->delete();

        $transaction->details()->delete();

        $transaction->delete();

    });

    return redirect()
        ->route('transactions.report')
        ->with('success', 'Transaksi berhasil dihapus.');
}

  public function report(Request $request)
{
    $query = Transaction::with('payments');

    if ($request->filled('from')) {

        $query->whereDate(
            'transaction_date',
            '>=',
            $request->from
        );

    }

    if ($request->filled('to')) {

        $query->whereDate(
            'transaction_date',
            '<=',
            $request->to
        );

    }

    if ($request->filled('status')) {

        $query->where(
            'payment_status',
            $request->status
        );

    }

    $transactions = $query
        ->latest()
        ->get();

    $totalTransaksi = $transactions->count();

    $totalPendapatan = $transactions
        ->where('payment_status', 'Lunas')
        ->sum('total');

    $belumLunas = $transactions
        ->where('payment_status', 'Belum Lunas')
        ->sum(function ($item) {
            return $item->total - $item->payments->sum('amount');
        });

    $lunas = $transactions
        ->where('payment_status', 'Lunas')
        ->sum('total');

    return view('transactions.report', compact(
        'transactions',
        'totalTransaksi',
        'totalPendapatan',
        'belumLunas',
        'lunas'
    ));
}
public function exportPdf()
{
    $transactions = Transaction::with('payments')
        ->latest()
        ->get();

    $pdf = Pdf::loadView(
        'transactions.pdf',
        compact('transactions')
    );

    return $pdf->download('laporan-transaksi.pdf');
}

public function invoicePdf(Transaction $transaction)
{
    $transaction->load([
        'details.service',
        'payments'
    ]);

    $pdf = Pdf::loadView(
        'transactions.invoice-pdf',
        compact('transaction')
    );

    return $pdf->download(
        'Invoice-' . $transaction->invoice . '.pdf'
    );
}
}