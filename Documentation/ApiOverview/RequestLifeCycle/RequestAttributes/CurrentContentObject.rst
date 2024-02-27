..  include:: /Includes.rst.txt

..  index::
    Request attribute; Current content object
..  _typo3-request-attribute-current-content-object:

======================
Current content object
======================

..  versionadded:: 12.4
    The Extbase-related method
    :php:`\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface->getContentObject()`
    was marked as deprecated in TYPO3 v12 and has been removed in TYPO3 v13.
    Instead, this request attribute can be used to retrieve the current
    content object.

Instances with :ref:`Extbase controllers <extbase-action-controller>` may need
to retrieve data from the current content object that initiated the frontend
Extbase plugin call.

In this case, controllers can access the current content object from the
Extbase request object.

Example:

..  code-block:: php

    /**
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $currentContentObject
     */
    $currentContentObject = $request->getAttribute('currentContentObject');
    // ID of current tt_content record
    $uid = $currentContentObject->data['uid'];
