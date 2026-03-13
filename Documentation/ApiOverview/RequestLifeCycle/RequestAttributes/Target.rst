..  include:: /Includes.rst.txt

..  index::
    Request attribute; Target
..  _typo3-request-attribute-target:

======
Target
======

The :php:`target` backend request attribute provides the target action of a
backend route. For instance, the target of the :guilabel:`Content > Records` module
is set to :php:`TYPO3\CMS\Recordlist\Controller\RecordListController::mainAction`.

Example:

..  code-block:: php

    $target = $request->getAttribute('target');
