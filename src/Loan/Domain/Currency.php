<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Loan\Domain;

use Brick\Money\Money;

enum Currency: string
{
    case PLN = 'PLN';

    public static function fromMoney(Money $money): Currency
    {
        $currencyCode = $money->getCurrency()->getCurrencyCode();

        return Currency::tryFrom($money->getCurrency()->getCurrencyCode()) ??
            throw new \InvalidArgumentException('Unable to create Currency from Money currency: ' . $currencyCode);
    }
}
