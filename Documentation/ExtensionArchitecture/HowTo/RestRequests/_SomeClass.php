<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\RequestFactory;

final readonly class SomeClass
{
  public function __construct(
    private RequestFactory $requestFactory,
  ) {}

  public function post(string $url): ResponseInterface
  {
    $additionalOptions = [
      'body' => 'Your raw post data',
      // OR form data:
      'form_params' => [
        'first_name' => 'Jane',
        'last_name' => 'Doe',
      ],
    ];

    return $this->requestFactory->request($url, 'POST', $additionalOptions);
  }
}
