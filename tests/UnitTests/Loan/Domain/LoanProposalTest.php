<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\UnitTests\Loan\Domain;

use Brick\Money\Money;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Loan\Domain\Term;
use PragmaGoTech\Interview\Loan\Domain\Currency;
use PragmaGoTech\Interview\Loan\Domain\LoanProposal;

class LoanProposalTest extends TestCase
{
    public function testOfWhenGivenProperArgumentsShouldReturnObject()
    {
        $term = Term::OF_24_MONTHS;
        $money = Money::of(3000, Currency::PLN->value);

        $SUT = LoanProposal::of($term, $money);

        $this->assertInstanceOf(LoanProposal::class, $SUT);
        $this->assertSame($term, $SUT->term);
        $this->assertSame($money, $SUT->money);
    }

    public function testOfWhenGivenTooSmallMoneyShouldThrowException(): void
    {
        $money = Money::of(5, Currency::PLN->value);

        self::expectException(\InvalidArgumentException::class);

        LoanProposal::of(Term::OF_12_MONTHS, $money);
    }

    public function testOfWhenGivenTooBigMoneyShouldThrowException(): void
    {
        $money = Money::of(5_000_000, Currency::PLN->value);

        self::expectException(\InvalidArgumentException::class);

        LoanProposal::of(Term::OF_12_MONTHS, $money);
    }

    public function testOfWhenGivenMoneyOfCurrencyShouldThrowException(): void
    {
        $money = Money::of(5_000_000, 'USD');

        self::expectException(\InvalidArgumentException::class);

        LoanProposal::of(Term::OF_12_MONTHS, $money);
    }
}
