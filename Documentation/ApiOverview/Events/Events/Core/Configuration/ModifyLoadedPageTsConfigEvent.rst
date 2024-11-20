..  include:: /Includes.rst.txt
..  index:: Events; ModifyLoadedPageTsConfigEvent
..  _ModifyLoadedPageTsConfigEvent:

=============================
ModifyLoadedPageTsConfigEvent
=============================

Extensions can modify :ref:`page TSconfig <t3tsref:pagetoplevelobjects>`
entries that can be overridden or added, based on the root line.

..  versionchanged:: 12.2
    The event has moved its namespace from
    :php:`\TYPO3\CMS\Core\Configuration\Event\ModifyLoadedPageTsConfigEvent` to
    :php:`\TYPO3\CMS\Core\TypoScript\IncludeTree\Event\ModifyLoadedPageTsConfigEvent`.
    Apart from that no changes were made. TYPO3 v12 triggers *both* the old
    and the new event, and TYPO3 v13 will stop calling the old event.
    See also :ref:`ModifyLoadedPageTsConfigEventv11v12`.


API
===

..  include:: /CodeSnippets/Events/Core/ModifyLoadedPageTsConfigEvent.rst.txt


..  _ModifyLoadedPageTsConfigEventv11v12:

Compatibility with TYPO3 v11 and v12
====================================

Extensions that want to stay compatible with both TYPO3 v11 and v12 and prepare v13
compatibility as much as possible should start listening for the new event as well,
and suppress handling of the old event in TYPO3 v12 to not handle things twice.

Example from b13/bolt extension:

Registration of both events in the file :file:`Services.yaml`:

..  literalinclude:: _ModifyLoadedPageTsConfigEvent/_Services.yaml
    :language: yaml
    :caption: EXT:bolt/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions <dependency-injection-in-extensions>`.

Handle the old event in TYPO3 v11 only, but skip old event with TYPO3 v12:

..  literalinclude:: _ModifyLoadedPageTsConfigEvent/_Loader.php
    :language: php
    :caption: EXT:bolt/Classes/TsConfig/Loader.php

See the complete code on GitHub:
`Loader.php <https://github.com/b13/bolt/blob/2.3.0/Classes/TsConfig/Loader.php>`__.
