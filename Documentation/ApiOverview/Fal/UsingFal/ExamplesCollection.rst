.. include:: ../../../Includes.txt



.. _fal-using-fal-examples-collections:

Working with collections
""""""""""""""""""""""""

The :php:`\TYPO3\CMS\Core\Resource\ResourceFactory` class
provides a convenience method to retrieve a
:ref:`File Collection <fal-architecture-components-collections>`.

.. code-block:: php

     $resourceFactory = ResourceFactory::getInstance();
     $collection = $resourceFactory->getCollectionObject(1);
     // Load the contents of the collection
     $collection->loadContents();


In this example, we retrieve and load the content from the
File Collection with a uid of "1". Any Collection implements
the :php:`\Iterator` interface, which means that a Collection
can be looped over (once its content has been loaded). Thus
if the above code passed the :php:`$collection` variable to
a Fluid view, you could do the following:

.. code-block:: html

	<ul>
		<f:for each="{collection}" as="file">
			<li>{file.title}</li>
		</f:for>
	</ul>
