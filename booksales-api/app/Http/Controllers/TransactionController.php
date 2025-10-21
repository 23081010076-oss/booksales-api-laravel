<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // ADMIN: Lihat semua transaksi
    public function index()
    {
        $transactions = Transaction::with(['customer', 'book'])->get();
        return response()->json([
            'status' => 'success',
            'message' => 'All transactions retrieved successfully',
            'data' => $transactions
        ], Response::HTTP_OK);
    }

    // CUSTOMER: Membuat transaksi
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $transaction = Transaction::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'customer_id' => Auth::id(),
            'book_id' => $request->book_id,
            'amount' => $request->amount
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction created successfully',
            'data' => $transaction->load(['customer', 'book'])
        ], Response::HTTP_CREATED);
    }

    // CUSTOMER: Melihat transaksi sendiri
    public function show($id)
    {
        $transaction = Transaction::with(['customer', 'book'])
            ->where('id', $id)
            ->where('customer_id', Auth::id())
            ->first();

        if (! $transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        return response()->json($transaction);
    }

    // CUSTOMER: Update transaksi miliknya
    public function update(Request $request, $id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('customer_id', Auth::id())
            ->first();

        if (! $transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0'
        ]);

        $transaction->update(['amount' => $request->amount]);

        return response()->json([
            'message' => 'Transaction updated successfully',
            'data' => $transaction
        ]);
    }

    // ADMIN: Hapus transaksi
    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (! $transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transaction->delete();

        return response()->json([], 204);
    }
}

