.. include:: ../../Includes.txt


Calling a chain of services
^^^^^^^^^^^^^^^^^^^^^^^^^^^

It is also possible to use services in a "chain". This means using all
the available services of a type instead of just one.

The method :code:`t3lib\_div::makeInstanceService()` accepts a third
parameter to exclude a number of services, using a comma-separated
list of service keys. This way you can walk through all available
services of a type by passing the already used service keys. Services
will be called in order of decreasing priority and quality.

The following example is an extract of the user authentication
process::

      // use 'auth' service to find the user
           // first found user will be used
   $serviceChain='';
   while (is_object($serviceObj = t3lib_div::makeInstanceService('auth', $subType, $serviceChain))) {
           $serviceChain .= ',' . $serviceObj->getServiceKey();

           if ($tempuser = $serviceObj->getUser($info, $subType, $this)) {
                           // user found, do something and exit the chain
             ...
                   break;
           }
   }

As you see the while loop is exited when a service gives a result.
More sophisticated mechanisms can be imagined. In this next example –
also taken from the authentication process – the loop is exited only
when a certain value is returned by the method called::

        // use 'auth' service to authenticate the user
     // if one service returns FALSE then authentication failed
     // a service might return 100 which means there's no reason to stop
     // but the user can't be authenticated by that service
   $serviceChain='';
   while (is_object($serviceObj = t3lib_div::makeInstanceService('auth', $subType, $serviceChain))) {
           $serviceChain .= ',' . $serviceObj->getServiceKey();
           $serviceObj->initAuth($subType, $loginData, $authInfo, $this);
           if (($ret = $serviceObj->authUser($tempuser))>0) {
                           // if the service returns >=200 then no more checking is needed
                     // useful for IP checking without password
                   if (intval($ret) >= 200) {
                           $authenticated = true;
                           break;
                   } elseif (intval($ret) >= 100) {
                           // Just go on. User is still not authenticated but there's no reason to stop now.
                   } else {
                           $authenticated = true;
                   }
           } else {
                   $authenticated = false;
                   break;
           }
   }

In the above example the loop will walk through all services of the
given type except if one service returns false or a value larger than
or equals to 200, in which case the chain is interrupted.

