.. include:: ../../Includes.txt


.. _using-services-service-chain:

Calling a chain of services
^^^^^^^^^^^^^^^^^^^^^^^^^^^

It is also possible to use services in a "chain". This means using all
the available services of a type instead of just one.

The method :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstanceService()` accepts a third
parameter to exclude a number of services, using an array of service keys.
This way you can walk through all available services of a type by passing the
already used service keys. Services will be called in order of decreasing
priority and quality.

The following example is an extract of the user authentication process::

   // Use 'auth' service to find the user. First user found will be used
   $subType = 'getUser' . $this->loginType;
   foreach ($this->getAuthServices($subType, $loginData, $authInfo) as $serviceObj) {
      if ($row = $serviceObj->getUser()) {
         $tempuserArr[] = $row;
         $this->logger->debug('User found', [
            $this->userid_column => $row[$this->userid_column],
            $this->username_column => $row[$this->username_column],
         ]);
         // User found, just stop to search for more if not configured to go on
         if (!$this->svConfig['setup'][$this->loginType . '_fetchAllUsers']) {
            break;
         }
      }
   }

   protected function getAuthServices(string $subType, array $loginData, array $authInfo): \Traversable
   {
      $serviceChain = '';
      while (is_object($serviceObj = GeneralUtility::makeInstanceService('auth', $subType, $serviceChain))) {
         $serviceChain .= ',' . $serviceObj->getServiceKey();
         $serviceObj->initAuth($subType, $loginData, $authInfo, $this);
         yield $serviceObj;
      }
      if ($serviceChain) {
         $this->logger->debug($subType . ' auth services called: ' . $serviceChain);
      }
   }


As you see the while loop is exited when a service gives a result.
More sophisticated mechanisms can be imagined. In this next example –
also taken from the authentication process – the loop is exited only
when a certain value is returned by the method called::

   foreach ($tempuserArr as $tempuser) {
      // Use 'auth' service to authenticate the user.
      // If one service returns FALSE then authentication fails.
      // A service may return 100 which means there's no reason to stop but the
      // user can't be authenticated by that service.
      $this->logger->debug('Auth user', $tempuser);
      $subType = 'authUser' . $this->loginType;

      foreach ($this->getAuthServices($subType, $loginData, $authInfo) as $serviceObj) {
         if (($ret = $serviceObj->authUser($tempuser)) > 0) {
            // If the service returns >=200 then no more checking is needed.
            // This is useful for IP checking without password.
            if ((int)$ret >= 200) {
               $authenticated = true;
               break;
            }
            if ((int)$ret >= 100) {
            } else {
               $authenticated = true;
            }
         } else {
            $authenticated = false;
            break;
         }
      }

      if ($authenticated) {
         // Leave foreach() because a user is authenticated
         break;
      }
   }

In the above example the loop will walk through all services of the
given type except if one service returns :php:`false` or a value larger than
or equals to 200, in which case the chain is interrupted.
