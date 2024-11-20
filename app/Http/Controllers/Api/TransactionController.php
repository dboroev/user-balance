<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller {
    public function index(Request $request) {
        return response()->json(
            $request->user()
                ->transactions()
                ->latest()
                ->get()
        );
    }
}
