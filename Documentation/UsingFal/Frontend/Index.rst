.. include:: ../../Includes.txt



.. _using-fal-frontend:

Using FAL in the frontend
^^^^^^^^^^^^^^^^^^^^^^^^^


.. _using-fal-frontend-typoScript:

TypoScript
""""""""""

Using FAL relations in the frontend via TypoScript is achieved
using the :code:`FILES` content object, which is described
in details in the :ref:`TypoScript Reference <t3tsref:cobj-files>`.


.. _using-fal-frontend-fluid:

Fluid
"""""


.. _using-fal-frontend-fluid-image:

The ImageViewHelper
~~~~~~~~~~~~~~~~~~~

If you have the uid of a File Reference, you can use it directly
in the :class:`\\TYPO3\\CMS\\Fluid\\ViewHelpers\\ImageViewHelper`:

.. code-block:: html

	<f:image src="xxx" treatIdAsReference="1" />

where :code:`xxx` is the uid of the File Reference.


.. _using-fal-frontend-fluid-fluidtemplate:

FLUIDTEMPLATE
~~~~~~~~~~~~~

More often than not the File Reference information will not be
available explicitely. The :ref:`FLUIDTEMPLATE <t3tsref:cobj-fluidtemplate>` content object
has a :ref:`dataProcessing <t3tsref:cobj-fluidtemplate-properties-dataprocessing>` property
which can be used to call up the :class:`\\TYPO3\\CMS\\Frontend\\DataProcessing\\FilesProcessor`
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
