<?php

namespace MyVendor\MyExtension\Authentication;

use TYPO3\CMS\Core\Authentication\AbstractAuthenticationService;

class MyAuthenticationService extends AbstractAuthenticationService
{
    public function authUser(array $user)
    {
        // only handle actual login requests
        if (($this->login['status'] ?? '') !== 'login') {
            // skip this service, hand over to next in chain
            return 100;
        }
        // ...
        // usual processing for valid login requests
        // ...
        return 0;
    }
}
