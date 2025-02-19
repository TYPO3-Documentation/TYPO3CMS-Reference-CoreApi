..  include:: /Includes.rst.txt
..  index:: Events; ModifyLinkExplanationEvent
..  _ModifyLinkExplanationEvent:

==========================
ModifyLinkExplanationEvent
==========================

While the removed hook effectively only allowed to modify the link explanation
of TCA `link` fields in case the resolved link type did not already match
one of those, implemented by TYPO3 itself, the new event allows to
always modify the link explanation of any type. Additionally, this also allows
to modify the `additionalAttributes`, displayed below the actual link
explanation field. This is especially useful for extended link handler setups.

To modify the link explanation, the following methods are available:

- :php:`getLinkExplanation()`: Returns the current link explanation data
- :php:`setLinkExplanation()`: Set the link explanation data
- :php:`getLinkExplanationValue()`: Returns a specific link explanation value
- :php:`setLinkExplanationValue()`: Sets a specific link explanation value

The link explanation array usually contains the following values:

- :php:`text` : The text to show in the link explanation field
- :php:`icon`: The markup for the icon, displayed in front of the link explanation field
- :php:`additionalAttributes`: The markup for additional attributes, displayed below the link explanation field

The current context can be evaluated using the following methods:

- :php:`getLinkData()`: Returns the resolved link data, such as the page uid
- :php:`getLinkParts()`: Returns the resolved link parts, such as `url`, `target` and `additionalParams`
- :php:`getElementData()`: Returns the full FormEngine `$data` array for the current element

Example
=======

..  literalinclude:: _ModifyLinkExplanationEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyLinkExplanationEvent.rst.txt
