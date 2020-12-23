.. include:: /Includes.rst.txt
.. _fal-using-fal-frontend:

=========================
Using FAL in the Frontend
=========================


.. _fal-using-fal-frontend-typoScript:

`TypoScript`:pn:
================

Using FAL relations in the frontend via `TypoScript`:pn: is achieved
using the :code:`FILES` content object, which is described
in details in the :ref:`TypoScript Reference <t3tsref:cobj-files>`.


.. _fal-using-fal-frontend-fluid:

Fluid
=====


.. _fal-using-fal-frontend-fluid-image:

The ImageViewHelper
-------------------

If you have the uid of a file reference, you can use it directly
in the :php:`\TYPO3\CMS\Fluid\ViewHelpers\ImageViewHelper`:

.. code-block:: html

	<f:image image="{image}" />

Here :code:`{image}` is an object of one of the following types:

* :code:`TYPO3\CMS\Core\Resource\File`
* :code:`TYPO3\CMS\Core\Resource\FileReference`
* :code:`TYPO3\CMS\Extbase\Domain\Model\FileReference`

Get file Properties
-------------------

Example:

.. code-block:: html

	{filereference.title}
	{filereference.description}
	{filereference.publicUrl}

.. tip::

   If you are in `Extbase`:pn: context, you usually have a :code:`TYPO3\CMS\Extbase\Domain\Model\FileReference` Domain Model instead of a "pure" :code:`\TYPO3\CMS\Core\Resource\FileReference` Object. In order to get the meta data, you need to resolve the    :code:`\TYPO3\CMS\Core\Resource\FileReference` first by accessing the "originalResource" property:

.. code-block:: html

	{filereference.originalResource.title}
	{filereference.originalResource.description}
	{filereference.originalResource.publicUrl}

.. note::

   The system extension "filemetadata" (if installed) provides some additional meta data fields for files, for example :code:`creator`, :code:`publisher`, :code:`copyright` and others. To access those fields in the frontend, you have to use a proxy method named :code:`properties`:

.. code-block:: html

	{filereference.properties.copyright}
	{filereference.properties.creator}

.. tip::

   Please also note that the additional fields provided by the "filemetadata" extension are not listed as properties when you use :code:`<f:debug>` on a :code:`\TYPO3\CMS\Core\Resource\FileReference` object.

*Note:* Some metadata fields, like title and description, can be entered either in the referenced file itself or in the reference or both. `TYPO3`:pn: automatically merges both sources when you access originalResource in `Fluid`:pn:. So `originalResource` returns the merged value. Values which are entered in the reference will override values from the file itself.


.. _fal-using-fal-frontend-fluid-fluidtemplate:

FLUIDTEMPLATE
-------------

More often the file reference information will not be
available explicitly. The :ref:`FLUIDTEMPLATE <t3tsref:cobj-fluidtemplate>` content object
has a :ref:`dataProcessing <t3tsref:cobj-fluidtemplate-properties-dataprocessing>` property
which can be used to call up the :php:`\TYPO3\CMS\Frontend\DataProcessing\FilesProcessor`
class, whose task it is to load all media referenced for the current
database record being processed.

This requires first a bit of `TypoScript`:pn:

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


This will fetch all files related to the content element being rendered
(referenced in the "image" field) and make them available in a variable
called :code:`images`. This can then be used in the `Fluid`:pn: template:

.. code-block:: html

	<f:for each="{images}" as="image">
		<div class="slide">
			<f:image image="{image.originalFile}" />
		</div>
	</f:for>
