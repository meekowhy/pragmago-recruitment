<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Loan\Domain;

enum Term: int
{
    case OF_12_MONTHS = 12;
    case OF_24_MONTHS = 24;
}
