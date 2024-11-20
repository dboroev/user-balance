<?php

namespace App\Console\Commands;

use App\DTO\CreateTransactionDTO;
use App\Enums\TransactionEnum;
use App\Exceptions\InsufficientBalanceException;
use App\Jobs\ProcessBalanceTransaction;
use App\Models\User;
use App\Services\TransactionService;
use Illuminate\Console\Command;

class ProcessTransaction extends Command {
    protected $signature = 'transaction:process {login} {amount} {description} {type=withdrawal|deposit} {--queue}';
    protected $description = 'Process a balance transaction';

    /**
     * @throws InsufficientBalanceException
     */
    public function handle(TransactionService $service): void
    {
        $user = User::query()->where('email', $this->argument('login'))->firstOrFail();
        $type = $this->argument('type');
        $amount = $this->argument('amount');
        $description = $this->argument('description');

        if ($this->option('queue')) {
            ProcessBalanceTransaction::dispatch($user, $amount, $description);
            $this->info('Transaction queued for processing');

            return;
        }

        $service->createTransaction(new CreateTransactionDTO(
            user: $user,
            amount: $amount,
            description: $description,
            type: $type
        ));

        $this->info("Transaction processed successfully");
    }
}
