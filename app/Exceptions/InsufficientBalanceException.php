<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class InsufficientBalanceException extends Exception
{
    public function __construct(
        string $message = 'Insufficient balance for this transaction',
        int $code = 422,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function render($request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
            'error' => 'insufficient_balance'
        ], $this->code);
    }
}
