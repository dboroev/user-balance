<?php

namespace App\Services;

use App\DTO\CreateTransactionDTO;
use App\Enums\TransactionEnum;
use App\Exceptions\InsufficientBalanceException;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    /**
     * @throws InsufficientBalanceException
     */
    public function createTransaction(CreateTransactionDTO $dto): Transaction
    {
        $amount = $dto->type === TransactionEnum::Withdrawal->value ? $dto->amount * -1 : $dto->amount;

        $newBalance = $dto->user->balance->amount + $amount;

        if ($newBalance < 0) {
            throw new InsufficientBalanceException();
        }

        return DB::transaction(function () use ($dto,$newBalance) {
            $dto->user->balance->update([
                'amount' => $newBalance
            ]);

            return Transaction::query()->create([
                'user_id' => $dto->user->id,
                'amount' => abs($dto->amount),
                'description' => $dto->description,
                'type' => $dto->type
            ]);
        });
    }
}
