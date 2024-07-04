<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Loan\Domain;

use Brick\Math\BigDecimal;

interface FeeCalculationPolicy
{
    public function calculate(LoanProposal $loanProposal): BigDecimal;
}
