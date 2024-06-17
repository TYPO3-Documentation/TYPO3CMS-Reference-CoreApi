<?php

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\UriInterface;
use TYPO3\CMS\Backend\Routing\UriBuilder;

class ModuleController
{
    public function __construct(
        private readonly UriBuilder $backendUriBuilder,
    ) {}

    private function getCreateLink(): UriInterface
    {
        $uriParameters =
            [
                'edit' =>
                    [
                        'tx_examples_haiku' =>
                            [
                                1 => 'new',
                            ],
                    ],
                'defVals' =>
                    [
                        'tx_examples_haiku' =>
                            [
                                'title' => 'New Haiku?',
                                'season' => 'Spring',
                            ],
                    ],

                'columnsOnly' => 'title,season,color',
            ];
        return $this->backendUriBuilder
            ->buildUriFromRoute('record_edit', $uriParameters);
    }
}
