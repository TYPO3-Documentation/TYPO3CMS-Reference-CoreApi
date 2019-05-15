.. include:: ../../../Includes.txt

.. _fal-using-fal-frontend:

=========================
Using FAL in the Frontend
=========================


.. _fal-using-fal-frontend-typoScript:

TypoScript
==========

Using FAL relations in the frontend via TypoScript is achieved
using the :code:`FILES` content object, which is described
in details in the :ref:`TypoScript Reference <t3tsref:cobj-files>`.


.. _fal-using-fal-frontend-fluid:

Fluid
=====


.. _fal-using-fal-frontend-fluid-image:

The ImageViewHelper
-------------------

If you have the uid of a File Reference, you can use it directly
in the :php:`\TYPO3\CMS\Fluid\ViewHelpers\ImageViewHelper`:

.. code-block:: html

	<f:image image="{image}" />

Here :code:`{image}` is an object of one of the following types:

* :code:`TYPO3\CMS\Core\Resource\File`
* :code:`TYPO3\CMS\Core\Resource\FileReference`
* :code:`TYPO3\CMS\Extbase\Domain\Model\FileReference`

Get File Properties
-------------------

If you have a file reference and want to get its properties like Metadata, you have to access "originalResource" first. Example:

.. code-block:: html

	{filereference.originalResource.title}
	{filereference.originalResource.description}
	{filereference.originalResource.publicUrl}

*Note:* Some metadata fields, like title and description, can be entered either in the referenced file itself or in the reference or both. TYPO3 automatically merges both sources when you access originalResource in Fluid. So `originalResource` returns the merged value. Values which are entered in the reference will override values from the file itself.


.. _fal-using-fal-frontend-fluid-fluidtemplate:

FLUIDTEMPLATE
-------------

More often the File Reference information will not be
available explicitly. The :ref:`FLUIDTEMPLATE <t3tsref:cobj-fluidtemplate>` content object
has a :ref:`dataProcessing <t3tsref:cobj-fluidtemplate-properties-dataprocessing>` property
which can be used to call up the :php:`\TYPO3\CMS\Frontend\DataProcessing\FilesProcessor`
class, whose task it is to load all media referenced for the current
database record being processed.

This requires first a bit of TypoScript:

.. code-block:: typoscript

	lib.carousel = FLUIDTEMPLATE
	lib.carousel {
		file = EXT:extension/Resources/Private/Templates/Carousel.html
		dataProcessing.10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
		dataProcessing.10 {
			references {
				table = tt_content
				fieldName = image
			}
			as = images
		}
	}


This will fetch all Files related to the content element being rendered
(referenced in the "image" field) and make them available in a variable
called :code:`images`. This can then be used in the Fluid template:

.. code-block:: html

	<f:for each="{images}" as="image">
		<div class="slide">
			<f:image image="{image.originalFile}" />
		</div>
	</f:for>
