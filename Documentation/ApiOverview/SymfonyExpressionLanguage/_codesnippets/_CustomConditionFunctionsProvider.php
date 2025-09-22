<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CustomConditionFunctionsProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions(): array
    {
        return [
            $this->getWebserviceFunction(),
        ];
    }

    protected function getWebserviceFunction(): ExpressionFunction
    {
        return new ExpressionFunction(
            'webservice',
            static fn() => null, // Not implemented, we only use the evaluator
            static function ($arguments, $endpoint, $uid) {
                return GeneralUtility::getUrl(
                    'https://example.org/endpoint/'
                    . $endpoint
                    . '/'
                    . $uid,
                );
            },
        );
    }
}
