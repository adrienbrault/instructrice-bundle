<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
    ])

    ->withRules([
        NoUnusedImportsFixer::class,
    ])

    ->withPreparedSets(
        psr12: true,
        common: true,
        strict: true,
        cleanCode: true,
    )

    ->withPhpCsFixerSets(
        symfony: true,
        symfonyRisky: true,
        php81Migration: true,
    )

    ->withSkip([
        GlobalNamespaceImportFixer::class,
        MethodChainingIndentationFixer::class,
    ])
;
