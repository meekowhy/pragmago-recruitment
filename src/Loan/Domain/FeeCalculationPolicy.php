<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Loan\Domain;

use Brick\Money\Money;

interface FeeCalculationPolicy
{
    public function calculate(LoanProposal $loanProposal): Money;
}
