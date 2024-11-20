<?php

namespace App\Enums;

enum TransactionEnum:string
{
    case Withdrawal = 'withdrawal';
    case Deposit = 'deposit';
}
