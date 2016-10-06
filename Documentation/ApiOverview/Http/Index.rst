.. include:: ../../Includes.txt






.. _http:

HTTP request library
--------------------

Since TYPO3 CMS 4.6, a library for easily making HTTP requests
is available. It is actually a wrapper around the
`HTTP_Request2 PEAR package <http://pear.php.net/manual/en/package.http.http-request2.php>`_,
which is shipped with the Core.


.. _http-basic:

Basic usage
^^^^^^^^^^^

The basic usage is as simple as it gets:

.. code-block:: php

   $request = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      'TYPO3\\CMS\\Core\\Http\\HttpRequest',
      'http://typo3.org/'
   );
   $result = $request->send();
   $content = $result->getBody();


The above example will read the content of the "typo3.org" home page.


.. _http-basic-example:

Example
^^^^^^^

This example is taken from the "linkvalidator" system extension.

.. code-block:: php

   $config = array(
      'follow_redirects' => TRUE,
      'strict_redirects' => TRUE
   );
   /** @var \TYPO3\CMS\Core\Http\HttpRequest|\HTTP_Request2 $request */
   $request = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      'TYPO3\\CMS\\Core\\Http\\HttpRequest',
      $url,
      'HEAD',
      $config
   );
   // Observe cookies
   $request->setCookieJar(TRUE);
   try {
      /** @var \HTTP_Request2_Response $response */
      $response = $request->send();
      // HEAD was not allowed, now trying GET
      if (isset($response) && $response->getStatus() === 405) {
         $request->setMethod('GET');
         $request->setHeader('Range', 'bytes = 0 - 4048');
         /** @var \HTTP_Request2_Response $response */
         $response = $request->send();
      }
   } catch (\Exception $e) {
      $isValidUrl = FALSE;
      // A redirect loop occurred
      if ($e->getCode() === 40) {
         // Parse the exception for more information
         $trace = $e->getTrace();
         $traceUrl = $trace[0]['args'][0]->getUrl()->getUrl();
         $traceCode = $trace[0]['args'][1]->getStatus();
         $errorParams['errorType'] = 'loop';
         $errorParams['location'] = $traceUrl;
         $errorParams['errorCode'] = $traceCode;
      } else {
         $errorParams['errorType'] = 'exception';
      }
      $errorParams['message'] = $e->getMessage();
   }


This is the code that checks external links. To keep the traffic low, it first checks
only with :code:`HEAD`. In case the server does not allow this, the check is retried
with :code:`GET`. In such a case, we get only the first 4 kilobytes, as we don't really
care about the content itself.

It may happen that the check gets stuck in a redirect loop, in which case an exception
is thrown. This particular case it tested for in the :code:`catch` block above
to better inform the user about what happened.
