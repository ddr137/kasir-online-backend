<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Exception;
class PaymentMethodController extends Controller
{
    public function index()
    {
        try {
            $paymentMethods = PaymentMethod::all();
            return response()->json($paymentMethods);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch payment methods',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
