<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\UnitTests\Loan\Domain;

use Brick\Money\Money;
use Brick\Math\BigDecimal;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Loan\Domain\Term;
use PragmaGoTech\Interview\Loan\Domain\Currency;
use PragmaGoTech\Interview\Loan\Domain\LoanProposal;
use PragmaGoTech\Interview\Loan\Domain\MultipleOfFiveFeeRoundingPolicy;

class MultipleOfFiveFeeRoundingPolicyTest extends TestCase
{
    /**
     * @dataProvider provideFees
     */
    public function testRoundGivenProperArgumentsShouldRoundUpFeeSuchThatFeeAndLoanIsExactMultiplierOf5(BigDecimal $expectedFee, LoanProposal $loanProposal, BigDecimal $fee)
    {
        $SUT = new MultipleOfFiveFeeRoundingPolicy();

        $roundedFee = $SUT->round($loanProposal, $fee);

        self::assertTrue($roundedFee->isEqualTo($expectedFee));
    }

    public static function provideFees(): array
    {
        return [
            'With loan + fee already multiple of 5' => [
                BigDecimal::of(15),
                LoanProposal::of(Term::OF_12_MONTHS, Money::of(1000, Currency::PLN->value)),
                BigDecimal::of(15),
            ],
            'With decimal fee' => [
                BigDecimal::of(20),
                LoanProposal::of(Term::OF_12_MONTHS, Money::of(1000, Currency::PLN->value)),
                BigDecimal::of(15.6675),
            ],
            'With decimal loan' => [
                BigDecimal::of(20),
                LoanProposal::of(Term::OF_12_MONTHS, Money::of(1000.22, Currency::PLN->value)),
                BigDecimal::of(15),
            ],
            'With decimal loan and decimal fee' => [
                BigDecimal::of(15),
                LoanProposal::of(Term::OF_12_MONTHS, Money::of(1000.22, Currency::PLN->value)),
                BigDecimal::of(14.12),
            ],
        ];
    }
}
