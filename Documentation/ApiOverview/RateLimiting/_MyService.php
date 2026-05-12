<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\RateLimiting;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\RateLimiter\RateLimiterFactoryInterface;

final readonly class MyService
{
    public function __construct(
        private RateLimiterFactoryInterface $rateLimiterFactory,
    ) {}

    public function doSomething(ServerRequestInterface $request): void
    {
        $limiter = $this->rateLimiterFactory->createRequestBasedLimiter(
            $request,
            [
                'id' => 'my-extension-action',
                'policy' => 'sliding_window',
                'limit' => 10,
                'interval' => '1 hour',
            ]
        );

        $limit = $limiter->consume();
        if (!$limit->isAccepted()) {
            // handle rate limit exceeded
        }
    }
}
