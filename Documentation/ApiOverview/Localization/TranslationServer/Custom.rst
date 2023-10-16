..  include:: /Includes.rst.txt
..  index:: Localization; Custom translation servers
..  _custom-translation-server:

==========================
Custom translation servers
==========================

With the usage of :ref:`XLIFF <xliff>` and the freely available `Pootle`_
translation server, companies and individuals may easily set up a custom
translation server for their extensions.

..  _Pootle: http://pootle.translatehouse.org/

The event :ref:`ModifyLanguagePackRemoteBaseUrlEvent` can be caught to change
the translation server URL, for example:

..  literalinclude:: /ApiOverview/Events/Events/Install/_ModifyLanguagePackRemoteBaseUrlEvent/_CustomMirror.php
    :language: php
    :caption: EXT:my_extension/Classes/EventListener/CustomMirror.php

In the above example, the URL is changed only for a given extension, but of
course it could be changed on a more general basis.

On the custom translation server side, the structure needs to be:

..  code-block:: text

    https://example.org/typo3-packages/
    `-- <first-letter-of-extension-key>
        `-- <second-letter-of-extension-key>
            `-- <extension-key>-l10n
                |-- <extension-key>-l10n-de.zip
                |-- <extension-key>-l10n-fr.zip
                `-- <extension-key>-l10n-it.zip

hence in our example:

..  code-block:: text

    https://example.org/typo3-packages/
    `-- m
        `-- y
            `-- my_extension-l10n
                |-- my_extension-l10n-de.zip
                |-- my_extension-l10n-fr.zip
                `-- my_extension-l10n-it.zip
