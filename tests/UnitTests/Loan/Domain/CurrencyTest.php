<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\UnitTests\Loan\Domain;

use Brick\Money\Money;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Loan\Domain\Currency;

class CurrencyTest extends TestCase
{
    public function testFromMoneyWhenGivenMoneyOfAvailableCurrencyWillReturnEnum(): void
    {
        $SUT = Currency::fromMoney(Money::of(10, 'PLN'));

        self::assertEquals(Currency::PLN, $SUT);
    }

    public function testFromMoneyWhenGivenMoneyOfUnavailableCurrencyWillThrowException(): void
    {
        self::expectException(\InvalidArgumentException::class);

        Currency::fromMoney(Money::of(10, 'USD'));
    }
}
