<?php

use Psr\Http\Message\UriInterface;

class ModuleController extends ActionController
{
    protected function getCreateHaikuLink(string $returnUrl): UriInterface
    {
        $uriParameters =
            [
                'edit' => [
                    'tx_examples_haiku' => [
                        1 => 'new',
                    ],
                ],
                'defVals' => [
                    'tx_examples_haiku' => [
                        'title' => 'New Haiku?',
                        'season' => 'Spring',
                    ],
                ],
                'columnsOnly' => [
                    'tx_examples_haiku' => [
                        'title',
                        'season',
                        'color',
                    ],
                ],
                'returnUrl' => $returnUrl,
            ];
        return $this->backendUriBuilder->buildUriFromRoute(
            'record_edit',
            $uriParameters,
        );
    }
}
