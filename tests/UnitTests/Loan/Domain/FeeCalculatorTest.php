<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\UnitTests\Loan\Domain;

use Brick\Money\Money;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Loan\Domain\Term;
use PragmaGoTech\Interview\Loan\Domain\Currency;
use PragmaGoTech\Interview\Loan\Domain\LoanProposal;
use PragmaGoTech\Interview\Loan\Domain\FeeCalculator;
use PragmaGoTech\Interview\Loan\Domain\MultipleOfFiveFeeRoundingPolicy;
use PragmaGoTech\Interview\Loan\Domain\InterpolationFeeCalculationPolicy;
use PragmaGoTech\Interview\Tests\Support\TestDouble\Loan\Domain\InMemoryFeeBreakpointsStub;

class FeeCalculatorTest extends TestCase
{
    /**
     * @dataProvider provideLoanProposals
     */
    public function testCalculateWhenGivenLoanProposalShouldReturnInterpolatedAndRoundedFee(Money $expectedFee, LoanProposal $loanProposal): void
    {
        $interpolationPolicy = new InterpolationFeeCalculationPolicy(new InMemoryFeeBreakpointsStub());
        $roundingPolicy = new MultipleOfFiveFeeRoundingPolicy();

        $SUT = new FeeCalculator($interpolationPolicy, $roundingPolicy);

        $fee = $SUT->calculate($loanProposal);

        self::assertTrue($fee->isEqualTo($expectedFee));
    }

    public static function provideLoanProposals(): array
    {
        return [
            'With 24 months term' => [
                Money::of(460, Currency::PLN->value),
                LoanProposal::of(Term::OF_24_MONTHS, Money::of(11500, Currency::PLN->value)),
            ],
            'With 12 months term' => [
                Money::of(385, Currency::PLN->value),
                LoanProposal::of(Term::OF_12_MONTHS, Money::of(19250, Currency::PLN->value)),
            ],
        ];
    }
}
