..  include:: /Includes.rst.txt

..  _frontend-requests:

=================
Frontend requests
=================

When handling a **frontend web request**, TYPO3 automatically sets up a rich
context that is used to render content and generate links correctly. Several
objects are created and configured during this process:

* **ContentObjectRenderer (cObj)** – Responsible for processing TypoScript-based
  rendering, including `typolink` and other link generation tasks.
* **page Attribute** – Holds the current page context
  and is used by many rendering processes.
* **PageInformation Object** – Provides additional metadata about the current page,
  such as title, navigation data, etc.
* **Router** – Resolves and generates URLs according to the configured site and routing setup.
* **FrontendTypoScriptFactory** – Collects and prepares TypoScript settings for the
  current request, including options like ``linkAccessRestrictedPages`` and
  ``typolinkLinkAccessRestrictedPages``.

These components work together only because the frontend request bootstrap
initializes them with all the necessary data: the current page, the current
``tt_content`` record, and the TypoScript configuration.

..  _frontend-requests-outside:

Limitations when there is no frontend request
=============================================

When executing code **outside** of a frontend request (for example, in a CLI
command), this context is missing:

* The ``ContentObjectRenderer (cObj)`` can be instantiated manually, but it will
  not have a populated ``data`` array because there is no ``tt_content`` record.
  As a result, TypoScript properties like ``field = my_field`` or ``data = my_data``
  will not work as expected.
* The ``FrontendTypoScriptFactory`` is not set up automatically in CLI either.
  If CLI-generated links should respect frontend settings (such as
  ``linkAccessRestrictedPages``), it must be instantiated and configured manually.

Understanding this difference is crucial when writing custom code that depends
on frontend rendering behavior but runs in a different context.

..  _frontend-requests-simulation:

Simulating a frontend request
=============================

It can become necessary to simulate a frontend request to make certain
functionality available where it would usually not be available.

For example you might need to simulate a frontend request to be able to send a
`FluidEmail <https://docs.typo3.org/permalink/t3coreapi:mail-fluid-email>`_
from a CLI / Console command context.

To simulate a frontend request you need at least a site. If the current site is
not defined you can use the `SiteFinder <https://docs.typo3.org/permalink/t3coreapi:sitehandling-sitefinder-object>`_
to find one.

..  code-block:: php

    use TYPO3\CMS\Core\Core\Bootstrap;
    use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
    use TYPO3\CMS\Core\Http\ServerRequest;
    use TYPO3\CMS\Core\Site\SiteFinder;

    $site = $this->siteFinder->getSiteByPageId(1);
    $request = (new ServerRequest())
        ->withAttribute('applicationType', SystemEnvironmentBuilder::REQUESTTYPE_FE)
        ->withAttribute('site', $site);

For a complete example on how to send a FluidEmail from a console command see
`Example: Sending a FluidEmail via console command <https://docs.typo3.org/permalink/t3coreapi:console-command-tutorial-fe-request-example>`_.

At this stage, the simulated frontend request still lacks page-related
information and does not load TypoScript. It remains a simplified simulation.

If you rely on any of these information you need to bootstrap them before using
them.

..  note::
    It is important to understand that there is no simple way to fully simulate
    a frontend request in CLI. Some aspects, like basic link generation, can
    work by manually setting request attributes. However, complex
    TypoScript-based link modifications, access restrictions, and context-aware
    rendering will not behave identically to a real web request. Developers
    need to be aware of these limitations when working with link generation in
    CLI commands.
