..  include:: /Includes.rst.txt
..  index:: Events; AfterFormStateInitializedEvent

..  _AfterFormStateInitializedEvent:

================================
`AfterFormStateInitializedEvent`
================================

..  versionadded:: 15.0
    :changelog: feature-109811-1759230000

    The event replaces the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/form']['afterFormStateInitialized']`
    and the interface
    :php:`\TYPO3\CMS\Form\Domain\Runtime\FormRuntime\Lifecycle\AfterFormStateInitializedInterface`.

The event :php:`\TYPO3\CMS\Form\Event\AfterFormStateInitializedEvent` is
dispatched after the form runtime has restored the form state from the
request. The submitted values and the form definition are both available.
A listener can read and change the form state through `$formRuntime` and
read the request in `$request`.

..  _AfterFormStateInitializedEvent-example:

Example: Fill a form field from a query parameter
=================================================

The following listener writes the query parameter `campaign` into the form
field `campaign`, unless the field already has a value. The form then sends
the campaign that the visitor came from along with the other values:

..  literalinclude:: _AfterFormStateInitializedEvent/_CampaignFromQueryListener.php
    :caption: EXT:my_extension/Classes/EventListener/CampaignFromQueryListener.php

..  _AfterFormStateInitializedEvent-api:

API
===

..  typo3:api-class:: \TYPO3\CMS\Form\Event\AfterFormStateInitializedEvent
