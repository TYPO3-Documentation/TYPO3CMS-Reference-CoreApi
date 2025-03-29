..  include:: /Includes.rst.txt
..  index:: Events; BeforeLiveSearchFormIsBuiltEvent
..  _BeforeLiveSearchFormIsBuiltEvent:

================================
BeforeLiveSearchFormIsBuiltEvent
================================

The PSR-14 event :php-short:`\TYPO3\CMS\Backend\Search\Event\BeforeLiveSearchFormIsBuiltEvent`
can be used to modify the form data for the backend live search.

This event allows extension developer to add, change or remove hints to
the live search form or change the search demand object.

Furthermore, additional view data can be provided and used in a
overridden module action template. This avoids the need for using
the `XCLASS <https://docs.typo3.org/permalink/t3coreapi:xclasses>`_
technique to provide additional data.

..  _BeforeLiveSearchFormIsBuiltEvent-example:

Example
=======

..  literalinclude:: _BeforeLiveSearchFormIsBuiltEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  _BeforeLiveSearchFormIsBuiltEvent-api:

API
===

..  include:: /CodeSnippets/Events/Backend/BeforeLiveSearchFormIsBuiltEvent.rst.txt

..  note::

    :php:`setAdditionalViewData()` becomes handy to provide additional data to
    the template without the need to cross class ("xclass") the controller. The
    additional view data can be used in an overridden backend template of the
    live search form.
