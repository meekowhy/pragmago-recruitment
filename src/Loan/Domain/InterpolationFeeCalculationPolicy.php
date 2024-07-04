<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Loan\Domain;

use Brick\Money\Money;
use Brick\Math\Exception\MathException;
use Brick\Math\Exception\NumberFormatException;
use Brick\Money\Exception\MoneyMismatchException;
use Brick\Money\Exception\UnknownCurrencyException;
use Brick\Math\Exception\RoundingNecessaryException;

class InterpolationFeeCalculationPolicy implements FeeCalculationPolicy
{
    public function __construct(
        private FeeBreakpoints $feeBreakpoints
    ) {
    }

    /**
     * @throws MathException
     * @throws MoneyMismatchException
     * @throws NumberFormatException
     * @throws RoundingNecessaryException
     * @throws UnknownCurrencyException
     */
    public function calculate(LoanProposal $loanProposal): Money
    {
        $breakpoints = $this->feeBreakpoints->getForLoanProposal($loanProposal);
        ksort($breakpoints);

        $proposedLoanMoney = $loanProposal->money;
        $proposedLoanCurrency = $proposedLoanMoney->getCurrency();

        $lowerBreakpointLoan = null;
        $lowerBreakpointFee = null;

        $upperBreakpointLoan = null;
        $upperBreakpointFee = null;

        foreach ($breakpoints as $loan => $fee) {
            if ($proposedLoanMoney->isEqualTo($loan)) {
                return Money::of($fee, $proposedLoanCurrency);
            }

            if ($proposedLoanMoney->isGreaterThan($loan)) {
                $lowerBreakpointLoan = Money::of($loan, $proposedLoanCurrency);
                $lowerBreakpointFee = Money::of($fee, $proposedLoanCurrency);
            } elseif ($proposedLoanMoney->isLessThan($loan)) {
                $upperBreakpointLoan = Money::of($loan, $proposedLoanCurrency);
                $upperBreakpointFee = Money::of($fee, $proposedLoanCurrency);
                break;
            }
        }

        if ($lowerBreakpointLoan === null || $upperBreakpointLoan === null) {
            throw new \RuntimeException('No fee breakpoint found');
        }

        $proposedLoanDiff = $proposedLoanMoney->minus($lowerBreakpointLoan)->getAmount();
        $breakpointsLoanDiff = $upperBreakpointLoan->minus($lowerBreakpointLoan)->getAmount();
        $breakpointsFeeDiff = $upperBreakpointFee->minus($lowerBreakpointFee)->getAmount();

        return $lowerBreakpointFee->plus($breakpointsFeeDiff->multipliedBy($proposedLoanDiff->dividedBy($breakpointsLoanDiff)));
    }
}
