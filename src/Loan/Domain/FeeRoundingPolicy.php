<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Loan\Domain;

use Brick\Money\Money;

interface FeeRoundingPolicy
{
    public function round(LoanProposal $loanProposal, Money $fee): Money;
}
