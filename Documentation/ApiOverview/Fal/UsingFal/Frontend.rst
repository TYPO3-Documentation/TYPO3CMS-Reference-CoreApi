..  include:: /Includes.rst.txt

..  _fal-using-fal-frontend:

=========================
Using FAL in the frontend
=========================

..  contents::
    :local:


.. _fal-using-fal-frontend-typoScript:

TypoScript
==========

Using :abbr:`FAL (File Abstraction Layer)` relations in the frontend via
TypoScript is achieved using the :typoscript:`FILES` content object, which is
described in detail in the :ref:`TypoScript Reference <t3tsref:cobj-files>`.


..  _fal-using-fal-frontend-fluid:

Fluid
=====

..  _fal-using-fal-frontend-fluid-image:

The ImageViewHelper
-------------------

If you have the uid of a file reference, you can use it directly in the
:ref:`\\TYPO3\\CMS\\Fluid\\ViewHelpers\\ImageViewHelper <t3viewhelper:typo3-fluid-image>`:

..  code-block:: html

	<f:image image="{image}" />

Here :html:`{image}` is an object of one of the following types:

*   :php:`\TYPO3\CMS\Core\Resource\File`
*   :php:`\TYPO3\CMS\Core\Resource\FileReference`
*   :php:`\TYPO3\CMS\Extbase\Domain\Model\FileReference`

Get file properties
-------------------

Example:

..  code-block:: html

	{fileReference.title}
	{fileReference.description}
	{fileReference.publicUrl}

..  tip::
    If you are in :ref:`Extbase <extbase>` context, you usually have a
    :php:`\TYPO3\CMS\Extbase\Domain\Model\FileReference`
    :ref:`domain model <extbase-model>` instead of a "pure"
    :php:`\TYPO3\CMS\Core\Resource\FileReference` object. In order to get the
    meta data, you need to resolve the :php:`\TYPO3\CMS\Core\Resource\FileReference`
    first by accessing the :html:`originalResource` property:

..  code-block:: html

	{fileReference.originalResource.title}
	{fileReference.originalResource.description}
	{fileReference.originalResource.publicUrl}

..  note::
    The system extension `filemetadata`_ (if installed) provides some additional
    meta data fields for files, for example :html:`creator`, :html:`publisher`,
    :html:`copyright` and others. To access those fields in the frontend, you
    have to use a proxy method named :html:`properties`:

    ..  _filemetadata: https://packagist.org/packages/typo3/cms-filemetadata

..  code-block:: html

	{fileReference.properties.copyright}
	{fileReference.properties.creator}

..  hint::
    The additional fields provided by the "filemetadata" extension are not
    listed as properties when you use :html:`<f:debug>` on a
    :php:`\TYPO3\CMS\Core\Resource\FileReference` object.

Some metadata fields, like title and description, can be entered either
in the referenced file itself or in the reference or both. TYPO3 automatically
merges both sources when you access :html:`originalResource` in Fluid. So
:html:`originalResource` returns the merged value. Values which are entered in
the reference will override values from the file itself.


..  _fal-using-fal-frontend-fluid-fluidtemplate:

FLUIDTEMPLATE
-------------

More often the file reference information will not be available explicitly. The
:ref:`FLUIDTEMPLATE <t3tsref:cobj-fluidtemplate>` content object has a
:ref:`dataProcessing <t3tsref:cobj-fluidtemplate-properties-dataprocessing>`
property which can be used to call the
:php:`\TYPO3\CMS\Frontend\DataProcessing\FilesProcessor` class, whose task is to
load all media referenced for the current database record being processed.

This requires first a bit of TypoScript:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

    lib.carousel = FLUIDTEMPLATE
    lib.carousel {
      file = EXT:my_extension/Resources/Private/Templates/Carousel.html
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
(referenced in the :typoscript:`image` field) and make them available in a
variable called :typoscript:`images`. This can then be used in the Fluid
template:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/Carousel.html

    <f:for each="{images}" as="image">
        <div class="slide">
            <f:image image="{image.originalFile}" />
        </div>
    </f:for>
