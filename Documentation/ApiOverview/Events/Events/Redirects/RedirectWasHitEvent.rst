.. include:: /Includes.rst.txt
.. index:: Events; RedirectWasHitEvent
.. _RedirectWasHitEvent:


===================
RedirectWasHitEvent
===================

.. versionadded:: 12.0

This event is fired in the
:php:`\TYPO3\CMS\Redirects\Http\Middleware\RedirectHandler`
middleware and allows extensions to further process the matched
redirect and to adjust the PSR-7 response.


API
---

.. include:: /CodeSnippets/Events/Redirects/RedirectWasHitEvent.rst.txt

Example: Disable the hit count increment for monitoring tools
-------------------------------------------------------------

TYPO3 already implements the :php:`IncrementHitCount` listener. It is
used to increment the hit count of the matched redirect record, if the
feature is enabled. In case you want to prevent the increment in some
cases, for example when the request was initiated by a monitoring tool, you
can either implement your own listener with the same identifier
(:yaml:`redirects-increment-hit-count`) or add your custom listener
before and dynamically set the records :php:`disable_hitcount` flag.


Registration of the event in the extensions' :file:`Services.yaml`:

.. code-block:: yaml

  MyVendor\MyPackage\Redirects\MyEventListener:
    tags:
      - name: event.listener
        identifier: 'my-package/redirects/validate-hit-count'
        before: 'redirects-increment-hit-count'

The corresponding event listener class:

.. code-block:: php

    use TYPO3\CMS\Redirects\Event\RedirectWasHitEvent;

    class MyEventListener {

        public function __invoke(RedirectWasHitEvent $event): void
        {
            $matchedRedirect = $event->getMatchedRedirect();

            // This will disable the hit count increment in case the target
            // is the page 123 and the request is from the monitoring tool.
            if (str_contains($matchedRedirect['target'], 'uid=123')
                && $event->getRequest()->getAttribute('normalizedParams')
                ->getHttpUserAgent() === 'my monitoring tool'
            ) {
                $matchedRedirect['disable_hitcount'] = true;
                $event->setMatchedRedirect(
                    $matchedRedirect
                );

                // Also add a custom response header
                $event->setResponse(
                    $event->getResponse()->withAddedHeader(
                       'X-Custom-Header',
                       'Hit count increment skipped')
                );
            }
        }
    }
