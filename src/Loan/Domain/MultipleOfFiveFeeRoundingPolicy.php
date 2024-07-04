<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Loan\Domain;

use Brick\Math\BigDecimal;

class MultipleOfFiveFeeRoundingPolicy implements FeeRoundingPolicy
{
    private const int MULTIPLIER = 5;
    public function round(LoanProposal $loanProposal, BigDecimal $fee): BigDecimal
    {
        $loanProposalValue = $loanProposal->money->getAmount();
        $sum = $loanProposalValue->plus($fee);

//        $sum->remainder()

//        var_dump($sum, $sum->remainder(self::MULTIPLIER)->isZero());die;

//        $sumRounded = $sum->remainder(self::MULTIPLIER)->isZero() ? $fee : $loanProposalValue->dividedBy(self::MULTIPLIER)->plus(1)->multipliedBy(self::MULTIPLIER);

        if ($sum->remainder(self::MULTIPLIER)->isZero()) {
            return $fee;
        }

        $sumRounded = $loanProposalValue->dividedBy(self::MULTIPLIER)->plus(1)->multipliedBy(self::MULTIPLIER);

        return $sumRounded->minus($loanProposalValue);
    }
}
