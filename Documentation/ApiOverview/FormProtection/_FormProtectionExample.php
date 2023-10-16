<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;

final class FormProtectionExample
{
    public function __construct(
        private readonly FormProtectionFactory $formProtectionFactory
    ) {}

    public function handleRequest(ServerRequestInterface $request): ResponseInterface
    {
        $formProtection = $this->formProtectionFactory->createFromRequest($request);

        $formToken = $formProtection->generateToken('BE user setup', 'edit');

        $content = '<input type="hidden" name="formToken" value="' . $formToken . '">';

        // ... some more logic ...
    }
}
