:navigation-title: Fluid Translate ViewHelper

..  include:: /Includes.rst.txt

..  _xliff-api-fluid:

===============================
Fluid: The translate ViewHelper
===============================

In Fluid, a typical call to fetch a string in the user's selected language looks like this:

..  code-block:: html

    <f:translate key="key1" extensionName="SomeExtensionName" />
    // or inline notation
    {f:translate(key: 'someKey', extensionName: 'SomeExtensionName')}

If the correct context is set, the current extension name and language will be
provided by the request. Otherwise it must be added.

..  seealso::

    ViewHelper Reference: `Translate ViewHelper <f:translate> <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-translate>`_
