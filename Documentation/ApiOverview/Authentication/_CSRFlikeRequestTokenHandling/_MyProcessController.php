<?php

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\SecurityAspect;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class MyController
{
    public function showFormAction()
    {
        // for the implementation, see above
    }

    public function processAction()
    {
        $context = GeneralUtility::makeInstance(Context::class);
        $securityAspect = SecurityAspect::provideIn($context);
        $requestToken = $securityAspect->getReceivedRequestToken();

        if ($requestToken === null) {
            // No request token was provided in the request
            // for example, (overridden) templates need to be adjusted
        } elseif ($requestToken === false) {
            // There was a request token, which could not be verified with the nonce
            // for example, when nonce cookie has been overridden by another HTTP request
        } elseif ($requestToken->scope !== 'my/process') {
            // There was a request token, but for a different scope
            // for example, when a form with different scope was submitted
        } else {
            // The request token was valid and for the expected scope
            $this->doTheMagic();
            // The middleware takes care to remove the cookie in case no other
            // nonce value shall be emitted during the current HTTP request
            if ($requestToken->getSigningSecretIdentifier() !== null) {
                $securityAspect->getSigningSecretResolver()->revokeIdentifier(
                    $requestToken->getSigningSecretIdentifier(),
                );
            }
        }
    }
}
