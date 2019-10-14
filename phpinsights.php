<?php
return [
    "preset" => "default",
    "remove" => [
        \NunoMaduro\PhpInsights\Domain\Insights\ForbiddenDefineFunctions::class,
        \PHP_CodeSniffer\Standards\Generic\Sniffs\ControlStructures\InlineControlStructureSniff::class,
        \SlevomatCodingStandard\Sniffs\ControlStructures\AssignmentInConditionSniff::class,
    ],
];
