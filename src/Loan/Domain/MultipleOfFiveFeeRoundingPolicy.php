<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Loan\Domain;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;

class MultipleOfFiveFeeRoundingPolicy implements FeeRoundingPolicy
{
    private const int MULTIPLIER = 5;

    public function round(LoanProposal $loanProposal, BigDecimal $fee): BigDecimal
    {
        $loanProposalValue = $loanProposal->money->getAmount();
        $sum = $loanProposalValue->plus($fee);

        $remainder = $sum->remainder(self::MULTIPLIER);

        if ($remainder->isZero()) {
            return $fee;
        }

        $roundingAmount = BigDecimal::of(5)->minus($remainder);

        return $fee->plus($roundingAmount)->toScale(0, RoundingMode::CEILING);
    }
}
