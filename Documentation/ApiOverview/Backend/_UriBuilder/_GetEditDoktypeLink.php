<?php

use Psr\Http\Message\UriInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ModuleController extends ActionController
{
  protected function getEditDoktypeLink(string $returnUrl): UriInterface
  {
    $uriParameters =
        [
          'edit' => [
            'pages' => [
              1 => 'edit',
              2 => 'edit',
            ],
            'tx_examples_haiku' => [
              1 => 'edit',
            ],
          ],
          'columnsOnly' => [
            'pages' => [
              'title',
              'doktype',
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
