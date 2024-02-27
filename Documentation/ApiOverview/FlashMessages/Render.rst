.. include:: /Includes.rst.txt
.. _flash-messages-renderer:

=======================
Flash messages renderer
=======================

The implementation of rendering FlashMessages in the Core has been optimized.

A new class called :php:`TYPO3\CMS\Core\Messaging\FlashMessageRendererResolver`
has been introduced. This class detects the context and renders the given
FlashMessages in the correct output format.
It can handle any kind of output format.
The Core ships with the following FlashMessageRenderer classes:

*  :php:`TYPO3\CMS\Core\Messaging\Renderer\BootstrapRenderer`
   This renderer is used by default in the TYPO3 backend.
   The output is based on Bootstrap markup.
*  :php:`TYPO3\CMS\Core\Messaging\Renderer\ListRenderer`
   This renderer is used by default in the TYPO3 frontend.
   The output is a simple :html:`<ul>` list.
*  :php:`TYPO3\CMS\Core\Messaging\Renderer\PlaintextRenderer`
   This renderer is used by default in the CLI context.
   The output is plain text.

All new rendering classes have to implement the :php:`TYPO3\CMS\Core\Messaging\Renderer\FlashMessageRendererInterface` interface.
If you need a special output format, you can implement your own renderer class and use it:

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeController.php

   use TYPO3\CMS\Core\Utility\GeneralUtility;
   use MyVendor\SomeExtension\Classes\Messaging\MySpecialRenderer;

   $out = GeneralUtility::makeInstance(MySpecialRenderer::class)
      ->render($flashMessages);


The Core has been modified to use the new :php:`FlashMessageRendererResolver`.
Any third party extension should use the provided :php:`FlashMessageViewHelper`
or the new :php:`FlashMessageRendererResolver` class:

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeController.php

   use TYPO3\CMS\Core\Utility\GeneralUtility;
   use TYPO3\CMS\Core\Messaging\FlashMessageRendererResolver;

   $out = GeneralUtility::makeInstance(FlashMessageRendererResolver::class)
      ->resolve()
      ->render($flashMessages);

