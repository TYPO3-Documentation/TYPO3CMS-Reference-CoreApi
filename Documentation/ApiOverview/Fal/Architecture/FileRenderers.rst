:navigation-title: File renderers

..  include:: /Includes.rst.txt
..  index:: File abstraction layer; File renderers
..  _fal-file-renderers:

===================================================
File renderers for the file abstraction layer (FAL)
===================================================

A file renderer returns the HTML output for a file that is no image, for
example the HTML tag :html:`<video>` for a video file. The ViewHelper
`<f:media> <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-media>`_
uses the first file renderer that can render the file, and renders the file as
an image if there is none.

TYPO3 Core ships file renderers for audio files, video files, and the online
media of YouTube and Vimeo. Extensions can add file renderers for other file
types.

..  contents:: Table of contents

..  _fal-file-renderers-register:

Register a file renderer with `#[AsFileRenderer]`
=================================================

..  versionchanged:: 15.0
    :changelog: breaking-110277-1784812454

    File renderers are registered as services. A registration with
    :php:`RendererRegistry->registerRendererClass()` in
    :file:`ext_localconf.php` has no effect anymore. The method
    :php:`getPriority()` was removed from
    :php-short:`\TYPO3\CMS\Core\Resource\Rendering\FileRendererInterface`,
    and the remaining methods are now strictly typed. To support TYPO3 v14
    as well, keep the registration in :file:`ext_localconf.php` and the
    method :php:`getPriority()`, add the attribute, and leave the parameters
    `$width` and `$height` untyped.

A file renderer implements
:php-short:`\TYPO3\CMS\Core\Resource\Rendering\FileRendererInterface`
and is registered with the PHP attribute
:php-short:`\TYPO3\CMS\Core\Attribute\AsFileRenderer`. This renderer embeds
PDF files in an :html:`<iframe>`:

..  literalinclude:: _FileRenderers/_PdfRenderer.php
    :caption: EXT:my_extension/Classes/Resource/Rendering/PdfRenderer.php

Method :php:`canRender()`
    Return :php:`true` if the renderer can render the given file or file
    reference.

Method :php:`render()`
    Return the HTML output for the file. `$width` and `$height` are numbers
    or numbers with a suffix like `200m` or `200c`, as in the
    `width property of imgResource <https://docs.typo3.org/permalink/t3tsref:confval-imgresource-width>`_.
    `$options` contains the arguments of the ViewHelper :html:`<f:media>`
    and the values of its argument `additionalConfig`.

A file renderer is a service, so it can use dependency injection in its
constructor.

..  _fal-file-renderers-priority:

Priority of file renderers
==========================

TYPO3 asks the file renderers in the order of their priority, the highest
first. The first renderer that can render the file renders it. The renderers
of TYPO3 Core have the priority `0`, so a renderer with a higher priority
takes precedence, for example to replace the video renderer. Give a renderer
a negative priority to ask it only after the renderers of TYPO3 Core. The
order of renderers with the same priority is not defined. Give each renderer
its own priority if the order matters.

..  _fal-file-renderers-service-tag:

Register a file renderer with the service tag `fal.file_renderer`
=================================================================

Instead of the attribute, the service tag :yaml:`fal.file_renderer` can be
used:

..  literalinclude:: _FileRenderers/_Services.yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

..  _fal-file-renderers-use:

Render a file with the ViewHelper `<f:media>`
=============================================

The ViewHelper :html:`<f:media>` renders each file with the file renderer
that can render it. With the example renderer, PDF files are embedded in an
:html:`<iframe>`, and images are still rendered as images:

..  literalinclude:: _FileRenderers/_Downloads.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/Downloads.fluid.html

The argument `title` reaches the renderer in `$options`. If a file has no
title, the example renderer uses the file name.
