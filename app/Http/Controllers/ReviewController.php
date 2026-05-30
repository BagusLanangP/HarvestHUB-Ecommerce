<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Request $request)
    {
        $transactionId = $request->query('transaction');
        $productId = $request->query('product');

        $transaction = Transaction::findOrFail($transactionId);
        $product = Product::findOrFail($productId);

        if ($transaction->user_id !== $request->user()->id || $transaction->status !== 'Completed') {
            abort(403, 'Unauthorized action or transaction not completed.');
        }

        return view('review.create', compact('transaction', 'product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $transaction = Transaction::findOrFail($request->transaction_id);

        if ($transaction->user_id !== $request->user()->id || $transaction->status !== 'Completed') {
            abort(403, 'Unauthorized action or transaction not completed.');
        }

        Review::create([
            'user_id' => $request->user()->id,
            'product_id' => $request->product_id,
            'transaction_id' => $request->transaction_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Ulasan berhasil ditambahkan.');
    }
}
