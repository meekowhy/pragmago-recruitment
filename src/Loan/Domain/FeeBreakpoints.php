<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Loan\Domain;

interface FeeBreakpoints
{
    /**
     * @return array<int, int>
     */
    public function getForTerm(Term $term): array;
}
