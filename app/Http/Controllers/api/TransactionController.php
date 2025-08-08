<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Exception;

class TransactionController extends Controller
{
    public function index()
    {
        try {
            $transactions = Transaction::all();
            return response()->json($transactions);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch transactions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'payment_method_id' => 'required|exists:payment_methods,id',
                'trx_number' => 'required|string|unique:transactions',
                'status' => 'required|string|in:pending,completed,cancelled',
                'total_price' => 'required|numeric|min:0',
                'paid_amount' => 'required|numeric|min:0',
                'change_amount' => 'required|numeric|min:0'
            ]);

            $transaction = Transaction::create($validatedData);

            return response()->json([
                'message' => 'Transaction created successfully',
                'data' => $transaction
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'payment_method_id' => 'required|exists:payment_methods,id',
                'trx_number' => 'required|string|unique:transactions',
                'status' => 'required|string|in:pending,completed,cancelled',
                'total_price' => 'required|numeric|min:0',
                'paid_amount' => 'required|numeric|min:0',
                'change_amount' => 'required|numeric|min:0'
            ]);

            $transaction = Transaction::findOrFail($id);
            $transaction->update($validatedData);

            return response()->json([
                'message' => 'Transaction updated successfully',
                'data' => $transaction
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
