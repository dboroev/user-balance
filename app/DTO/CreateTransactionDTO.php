<?php

namespace App\DTO;

use App\Models\User;

class CreateTransactionDTO
{
    public function __construct(
        public readonly User $user,
        public readonly float $amount,
        public readonly string $description,
        public readonly string $type,
    )
    {
    }
}
