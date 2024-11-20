<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'balance' => $request->user()->balance()->first()->amount,
            'recent_transactions' => $request->user()->transactions()
                ->latest()
                ->take(5)
                ->get()
        ]);
    }
}
