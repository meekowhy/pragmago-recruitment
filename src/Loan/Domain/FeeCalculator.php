<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Loan\Domain;

use Brick\Money\Money;

class FeeCalculator
{
    public function __construct(
        private FeeCalculationPolicy $feeCalculationPolicy,
        private FeeRoundingPolicy $feeRoundingPolicy
    ) {
    }

    public function calculate(LoanProposal $loanProposal): Money
    {
        $fee = $this->feeCalculationPolicy->calculate($loanProposal);
        $fee = $this->feeRoundingPolicy->round($loanProposal, $fee);

        return Money::of($fee, $loanProposal->money->getCurrency());
    }
}
