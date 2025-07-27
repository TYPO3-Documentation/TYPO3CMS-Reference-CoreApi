:navigation-title: Frontend Requests

..  include:: /Includes.rst.txt
..  _frontend-requests:

=================
Frontend requests
=================

When handling a **frontend web request**, TYPO3 automatically sets up a rich
context that is used to render content and generate links correctly. Several
objects are created and configured during this process:

*   **ContentObjectRenderer (cObj)** – Responsible for processing
    TypoScript-based rendering, including
    `typolink <https://docs.typo3.org/permalink/t3tsref:typolink>`_ and other link generation tasks.
*   **page Attribute** – Holds the current page context and is used by many
    rendering processes.
*   **PageInformation Object**: Provides additional metadata about the current
    page.
*   **Router**: Ensures proper URL resolution.
*   **FrontendTypoScriptFactory**: Collects
    TypoScript and provides settings like `linkAccessRestrictedPages` and
    `typolinkLinkAccessRestrictedPages`.

These components work together only because the frontend request bootstrap
initializes them with all the necessary data.

..  _frontend-requests-outside:

Limitations when there is no frontend request
=============================================

When executing code **outside** of a frontend request (for example, in a CLI
command), this context is missing:

*   The `ContentObjectRenderer (cObj) <https://docs.typo3.org/permalink/t3coreapi:tsfe-contentobjectrenderer>`_
    can be instantiated manually, but it will
    not have a populated `data` array because there is no `tt_content` record.
    As a result, TypoScript properties like `field = my_field` or `data = my_data`
    will not work as expected.
*   The :php-short:`\TYPO3\CMS\Core\TypoScript\FrontendTypoScriptFactory`
    is not set up automatically in CLI either.

Understanding this difference is crucial when writing custom code that depends
on frontend rendering behavior but runs in a different context.

..  _console-command-tutorial-fe-request-challenge:
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

The following example demonstrates how to set up a basic frontend request with
`applicationType` and `site` attributes:

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
    a frontend request. Some aspects, like basic link generation, can
    work by manually setting request attributes. However, complex
    TypoScript-based link modifications, access restrictions, and context-aware
    rendering will not behave identically to a real web request.
