<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Loan\Domain;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Brick\Math\Exception\MathException;
use Brick\Math\Exception\NumberFormatException;
use Brick\Math\Exception\DivisionByZeroException;

class InterpolationFeeCalculationPolicy implements FeeCalculationPolicy
{
    private const int DIVISION_PRECISION = 4;

    private const RoundingMode DIVISION_ROUNDING = RoundingMode::UP;

    public function __construct(
        private FeeBreakpoints $feeBreakpoints
    ) {
    }

    /**
     * @throws DivisionByZeroException
     * @throws MathException
     * @throws NumberFormatException
     */
    public function calculate(LoanProposal $loanProposal): BigDecimal
    {
        $breakpoints = $this->feeBreakpoints->getForLoanProposal($loanProposal);
        ksort($breakpoints);

        $proposedLoanAmount = $loanProposal->money->getAmount();

        $lowerBreakpointLoan = null;
        $lowerBreakpointFee = null;

        $upperBreakpointLoan = null;
        $upperBreakpointFee = null;

        foreach ($breakpoints as $loan => $fee) {
            if ($proposedLoanAmount->isEqualTo($loan)) {
                return BigDecimal::of($fee);
            }

            if ($proposedLoanAmount->isGreaterThan($loan)) {
                $lowerBreakpointLoan = BigDecimal::of($loan);
                $lowerBreakpointFee = BigDecimal::of($fee);
            } elseif ($proposedLoanAmount->isLessThan($loan)) {
                $upperBreakpointLoan = BigDecimal::of($loan);
                $upperBreakpointFee = BigDecimal::of($fee);
                break;
            }
        }

        if (!($lowerBreakpointLoan && $lowerBreakpointFee && $upperBreakpointFee && $upperBreakpointLoan)) {
            throw new \RuntimeException('No fee breakpoint found');
        }

        $proposedLoanDiff = $proposedLoanAmount->minus($lowerBreakpointLoan);
        $breakpointsLoanDiff = $upperBreakpointLoan->minus($lowerBreakpointLoan);
        $breakpointsFeeDiff = $upperBreakpointFee->minus($lowerBreakpointFee);

        return $lowerBreakpointFee->plus($breakpointsFeeDiff->multipliedBy($proposedLoanDiff->dividedBy($breakpointsLoanDiff, self::DIVISION_PRECISION, self::DIVISION_ROUNDING)));
    }
}
