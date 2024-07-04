<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Loan\Domain;

use Brick\Math\BigDecimal;

interface FeeRoundingPolicy
{
    public function round(LoanProposal $loanProposal, BigDecimal $fee): BigDecimal;
}
