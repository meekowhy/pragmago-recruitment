<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Loan\Domain;

use Brick\Math\RoundingMode;
use Brick\Money\Money;

class MultipleOfFiveFeeRoundingPolicy implements FeeRoundingPolicy
{
    private const int MULTIPLIER = 5;
    public function round(LoanProposal $loanProposal, Money $fee): Money
    {
        $sum = $loanProposal->money->plus($fee);
        $sumRounded = $sum->dividedBy(self::MULTIPLIER, RoundingMode::UP)->multipliedBy(self::MULTIPLIER);

        return $sumRounded->minus($loanProposal->money);

    }
}
