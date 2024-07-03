<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $ecsConfig->sets([
        SetList::PSR_12,
        SetList::CLEAN_CODE,
        SetList::COMMENTS,
        SetList::SPACES,
        SetList::ARRAY,
        SetList::COMMON,
        SetList::STRICT,
        SetList::PHPUNIT,
        SetList::DOCBLOCK,
        SetList::CONTROL_STRUCTURES,
        SetList::NAMESPACES
    ]);

    $ecsConfig->ruleWithConfiguration(OrderedImportsFixer::class, [
        'imports_order' => ['class', 'function', 'const'],
        'sort_algorithm' => 'length'
    ]);

    $ecsConfig->ruleWithConfiguration(ArraySyntaxFixer::class, [
        'syntax' => 'short',
    ]);
};
