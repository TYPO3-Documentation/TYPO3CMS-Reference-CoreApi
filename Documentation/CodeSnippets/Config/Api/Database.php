<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Database\Middleware\UsableForConnectionInterface::class,
        'members' => [
            'canBeUsedForConnection',
        ],
        'targetFileName' => 'CodeSnippets/Manual/Database/UsableForConnectionInterface.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder::class,
        'targetFileName' => 'ApiOverview/Database/ExpressionBuilder/_ExpressionBuilderLength.rst.txt',
        'includeClassComment' => false,
        'members' => [
            'length',
        ],
        'withCode' => false,
        'noindexInClass' => true,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder::class,
        'targetFileName' => 'ApiOverview/Database/ExpressionBuilder/_ExpressionBuilderTrim.rst.txt',
        'includeClassComment' => false,
        'members' => [
            'trim',
        ],
        'withCode' => false,
        'noindexInClass' => true,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder::class,
        'targetFileName' => 'ApiOverview/Database/ExpressionBuilder/_ExpressionBuilderAggregate.rst.txt',
        'includeClassComment' => false,
        'members' => [
            'min', 'max', 'avg', 'sum', 'count',
        ],
        'withCode' => false,
        'noindexInClass' => true,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder::class,
        'targetFileName' => 'ApiOverview/Database/ExpressionBuilder/_ExpressionBuilderComparisons.rst.txt',
        'includeClassComment' => false,
        'members' => [
            'eq', 'neq', 'lt', 'lte', 'gt', 'gte', 'isNull', 'isNotNull', 'like', 'notLike', 'in', 'notIn', 'inSet', 'notInSet', 'bitAnd',
        ],
        'withCode' => false,
        'noindexInClass' => true,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder::class,
        'targetFileName' => 'ApiOverview/Database/ExpressionBuilder/_ExpressionBuilder.rst.txt',
        'members' => [
            '__construct',
        ],
        'withCode' => false,
    ],
];
