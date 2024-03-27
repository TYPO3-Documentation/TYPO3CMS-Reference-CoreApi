<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\ExampleModel;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

final class SomeController extends ActionController
{
    public function showAction(ExampleModel $example): ResponseInterface
    {
        // ...

        $this->getFrontendController()->addCacheTags([
            sprintf('tx_myextension_example_%d', $example->getUid()),
        ]);

        // ...
    }

    private function getFrontendController(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
