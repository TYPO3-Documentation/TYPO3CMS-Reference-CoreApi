<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Http;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\RequestFactory;

final readonly class NewsletterSubscriber
{
  private const API_URL = 'https://newsletter.example.org/subscribe';

  public function __construct(
    private RequestFactory $requestFactory,
  ) {}

  public function subscribe(string $first, string $last): ResponseInterface
  {
    // Send the data URL-encoded, like an HTML form does. To send raw data,
    // use the option 'body' instead.
    $additionalOptions = [
      'form_params' => [
        'first_name' => $first,
        'last_name' => $last,
      ],
    ];

    return $this->requestFactory->request(
      self::API_URL,
      'POST',
      $additionalOptions,
    );
  }
}
