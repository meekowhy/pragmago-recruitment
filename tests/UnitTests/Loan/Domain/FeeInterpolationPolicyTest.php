<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\UnitTests\Loan\Domain;

use Brick\Money\Money;
use Brick\Math\BigDecimal;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Loan\Domain\Term;
use PragmaGoTech\Interview\Loan\Domain\Currency;
use PragmaGoTech\Interview\Loan\Domain\LoanProposal;
use PragmaGoTech\Interview\Loan\Domain\FeeInterpolationPolicy;
use PragmaGoTech\Interview\Tests\Support\TestDouble\Loan\Domain\InMemoryFeeBreakpointsStub;

class FeeInterpolationPolicyTest extends TestCase
{
    /**
     * @dataProvider provideLoanProposals
     */
    public function testInterpolateFeeGivenProperLoanProposalShouldReturnFee(BigDecimal $expectedFee, LoanProposal $loanProposal): void
    {
        $feeBreakpointsStub = new InMemoryFeeBreakpointsStub();

        $SUT = new FeeInterpolationPolicy($feeBreakpointsStub);

        $fee = $SUT->interpolateFee($loanProposal);

        $this->assertTrue($fee->isEqualTo($expectedFee));
    }

    public static function provideLoanProposals(): array
    {
        return [
            [BigDecimal::of(50.00), LoanProposal::of(Term::OF_12_MONTHS, Money::of(1000, Currency::PLN->value))],
            [BigDecimal::of(70.00), LoanProposal::of(Term::OF_12_MONTHS, Money::of(1500, Currency::PLN->value))],
            [BigDecimal::of(402.00), LoanProposal::of(Term::OF_12_MONTHS, Money::of(20000, Currency::PLN->value))],
        ];
    }
}
