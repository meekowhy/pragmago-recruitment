<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Loan\Domain;

use Brick\Money\Money;

class FeeCalculator
{
    public function __construct(private FeeCalculationPolicy $feeCalculationPolicy, private FeeRoundingPolicy $feeRoundingPolicy)
    {
    }

    public function calculate(LoanProposal $loanProposal): Money
    {

    }
}
