<?php

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\UriInterface;
use TYPO3\CMS\Backend\Routing\UriBuilder;

class ModuleController
{
    public function __construct(
        private readonly UriBuilder $backendUriBuilder,
    ) {}

    private function getEditLink(): UriInterface
    {
        $uriParameters =
            [
                'edit' =>
                    [
                        'pages' =>
                            [
                                1 => 'edit',
                                2 => 'edit',
                            ],
                        'tx_examples_haiku' =>
                            [
                                1 => 'edit',
                            ],
                    ],
                'columnsOnly' => 'title,doktype',
            ];
        return $this->backendUriBuilder
            ->buildUriFromRoute('record_edit', $uriParameters);
    }
}
