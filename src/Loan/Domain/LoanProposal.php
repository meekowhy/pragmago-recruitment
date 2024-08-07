<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Loan\Domain;

use Brick\Money\Money;
use InvalidArgumentException;

readonly class LoanProposal
{
    private const int MIN_LOAN_PLN = 1_000;

    private const int MAX_LOAN_PLN = 20_000;

    private function __construct(
        public Term $term,
        public Money $money
    ) {
    }

    public static function of(Term $term, Money $money): self
    {
        if ($money->isLessThan(self::MIN_LOAN_PLN) || $money->isGreaterThan(self::MAX_LOAN_PLN)) {
            throw new InvalidArgumentException('Loan proposal out of range');
        }

        if (!$money->getCurrency()->is(Currency::PLN->value)) {
            throw new InvalidArgumentException('Loan proposal invalid currency');
        }

        return new self($term, $money);
    }
}
