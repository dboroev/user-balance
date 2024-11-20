<?php

namespace App\Jobs;

use App\DTO\CreateTransactionDTO;
use App\Enums\TransactionEnum;
use App\Models\User;
use App\Services\TransactionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessBalanceTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;
    protected float $amount;
    protected string $description;
    protected string $type;

    public function __construct(User $user, float $amount, string $description, string $type)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->description = $description;
        $this->type = $type;
    }

    public function handle(TransactionService $service): void
    {
        $service->createTransaction(new CreateTransactionDTO(
            user: $this->user,
            amount: $this->amount,
            description: $this->description,
            type: $this->type
        ));
    }
}
