..  include:: /Includes.rst.txt

..  _fal-using-fal-examples-collections:

========================
Working with collections
========================

The :php:`\TYPO3\CMS\Core\Resource\ResourceFactory` class
provides a convenience method to retrieve a
:ref:`File Collection <fal-architecture-components-collections>`.

..  literalinclude:: _ExamplesCollection/_CollectionExample.php
    :language: php
    :caption: EXT:my_extension/Classes/CollectionExample.php

In this example, we retrieve and load the content from the
:ref:`File Collection <collections-files>` with a uid of "1". Any collection
implements the :php:`\Iterator` interface, which means that a collection
can be looped over (once its content has been loaded). Thus,
if the above code passed the :php:`$collection` variable to
a :ref:`Fluid <fluid>` view, you could do the following:

..  literalinclude:: _ExamplesCollection/_Iteration.html
    :language: html
