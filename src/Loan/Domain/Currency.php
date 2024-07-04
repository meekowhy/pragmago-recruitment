<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Loan\Domain;

use Brick\Money\Money;

enum Currency: string
{
    case PLN = 'PLN';

    public static function fromMoney(Money $money): Currency
    {
        return Currency::from($money->getCurrency()->getCurrencyCode());
    }

}
