<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;

final class MyService
{
  public function doSomethingToFrontendUser(
    ServerRequestInterface $request,
  ): void {
    /** @var FrontendUserAuthentication $frontendUserAuthentification */
    $frontendUserAuthentification = $request->getAttribute('frontend.user');
    $frontendUserAuthentification->fetchGroupData($request);
    // do something
  }
}
