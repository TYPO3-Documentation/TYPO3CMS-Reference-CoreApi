<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller\MyController;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

final class MyLinkViewHelper extends AbstractViewHelper
{
    public function __construct(private UriBuilder $uriBuilder) {}

    public function render(): string
    {
        if ($this->renderingContext->hasAttribute(ServerRequestInterface::class)) {
            // TYPO3 v13+ compatibility
            $request = $this->renderingContext->getAttribute(ServerRequestInterface::class);
        } else {
            throw new \RuntimeException(
                'The rendering context of this ViewHelper is missing a valid request object, probably because it is used outside of Extbase context.',
                1730537505,
            );
        }

        // Request context is needed before $this->uriBuilder is first used for returning links.
        // Note: this will not be reset on calling $this->uriBuilder->reset()!
        $this->uriBuilder->setRequest($request);

        $url = $this->uriBuilder
            ->reset()
            ->setTargetPageUid(2751)
            ->uriFor(
                'anotherAction',
                [
                    'myRecord' => 21,
                ],
                'MyController',
                'myextension',
                'myplugin',
            );

        // do something with $url, for example:
        return 'Link: ' . $url . '</a>';
    }
}
