..  include:: /Includes.rst.txt

..  index:: Extbase, FileUpload

..  _extbase_fileupload:

===========
File upload
===========

Implementing file uploads / attachments to Extbase domain models
has always been a bit of a challenge.

While it is straight-forward to access an existing file reference in a domain model,
writing new files to the :ref:`FAL (File Access Layer) <t3coreapi:using-fal>`
takes more effort.

..  _extbase_fileupload_accessing:

Accessing a file reference in an Extbase domain model
-----------------------------------------------------

You need two components for the structural information: the Domain
Model definition and the TCA entry.

The domain model definition:

..  literalinclude:: _FileUpload/_Blog.php
    :caption: EXT:my_extension/Classes/Domain/Model/Blog.php

and the TCA definition:

..  literalinclude:: _FileUpload/_tx_myextension_domain_model_blog.php
    :caption: EXT:my_extension/Configuration/TCA/tx_myextension_domain_model_blog.php

Once this is set up, you can create/edit records through the TYPO3
backend (for example via :guilabel:`Web > List`), attach a single or
multiple files in it. Then using a normal
controller and Fluid template, you can display an image.

The relevant Extbase controller part:

..  literalinclude:: _FileUpload/_BlogController.php
    :caption: EXT:my_extension/Classes/Controller/BlogController.php

and the corresponding Fluid template:

..  literalinclude:: _FileUpload/_Show.html
    :caption: EXT:my_extension/Resources/Private/Templates/Blog/Show.html

On the PHP side within controllers, you can use the usual
:php:`$blogItem->getSingleFile()` and :php:`$blogItem->getMultipleFiles()`
Extbase getters to retrieve the FileReference object.

..  _extbase_fileupload_writing:

Writing FileReference entries
-----------------------------

..  _extbase_fileupload_writing-manual:

Manual handling
...............

With TYPO3 versions below v13.3, attaching files to an Extbase domain model
was only possible by either:

*  Manually evaluate the :php:`$_FILES` data, process and validate the data,
   use raw QueryBuilder write actions on :sql:`sys_file` and :sql:`sys_file_reference`
   to persist the files quickly, or use at least some API methods:

   ..  literalinclude:: _FileUpload/_ApiUpload.php
       :caption: EXT:my_extension/Classes/Controller/BlogController.php, excerpt

   Instead of raw access to :php:`$_FILES`, starting with TYPO3 v12 the recommendation
   is to utilize the :ref:`UploadedFile objects instead of $_FILES <changelog:breaking-97214>`.
   In that case, validators can be used for custom UploadedFile objects to specify restrictions
   on file types, file sizes and image dimensions.

*  Use (or better: adapt) a more complex implementation by using Extbase TypeConverters,
   as provided by `Helmut Hummel's EXT:upload_example <https://github.com/helhum/upload_example>`__.
   This extension is no longer maintained and will not work without larger adaptation for
   TYPO3 v12 compatibility.

..  _extbase_fileupload_writing-attributes:

Automatic handling based on PHP attributes
..........................................

Starting with TYPO3 v13.3 it is finally possible to streamline this with commonly
known Extbase logic, as implemented via
:ref:`Feature: #103511 - Introduce Extbase file upload and deletion handling <changelog:feature-103511-1711894330>`.

An example implementation of this can be found on
`Torben Hansen's EXT:extbase-upload <https://github.com/derhansen/extbase_upload>`__
repository.

The general idea is to use PHP attributes within the Extbase Model, and for the upload
use a custom ViewHelper.

The domain model:

..  literalinclude:: _FileUpload/_BlogEnhanced.php
    :caption: EXT:my_extension/Classes/Domain/Model/Blog.php, using FileUpload attributes

and the corresponding Fluid template utilizing the ViewHelper:

..  literalinclude:: _FileUpload/_Upload.html
    :caption: EXT:my_extension/Resources/Private/Templates/Blog/New.html

You can also allow to remove already uploaded files (for the user):

..  literalinclude:: _FileUpload/_UploadDelete.html
    :caption: EXT:my_extension/Resources/Private/Templates/Blog/New.html

The controller action part with persisting the data needs no further custom code,
Extbase can automatically do all the domain model handling on its own. The TCA can
also stay the same as configured for simply read-access to a domain model. The only
requirement is that you take care of persisting the domain model after create/update
actions:

..  literalinclude:: _FileUpload/_BlogControllerUpload.php
    :emphasize-lines: 41,54
    :caption: EXT:my_extension/Resources/Private/Templates/Blog/New.html

The actual file upload processing is done after extbase property mapping was successful.
If not all properties of a domain model are valid, the file will not be uploaded.
This means, if any error occurs, a user will have to re-upload a file.

The implementation is done like this to prevent stale temporary files that would
need cleanup or could raise issues with Denial of Service (by filling up disk-space
with these temporarily uploaded files).

..  note::

    File upload handling for nested domain models (e.g. modelA.modelB.fileReference)
    is not supported.

..  important::

    When working with file uploads in domain models, it is required to persist the
    model within the same request in your Controller of the target action, for example
    via :php:`$myRepository->add($myModel)`. Otherwise, dangling `sys_file` records will
    be created, without a :php:`FileReference` in place, leading to stale temporary
    files that will need cleanup.

..  _extbase_fileupload_attribute:

Reference for the :php:`FileUpload` PHP attribute
-------------------------------------------------

File uploads can be validated by the following rules:

*   minimum and maximum file count
*   minimum and maximum file size
*   allowed MIME types
*   image dimensions (for image uploads)

Additionally, it is ensured, that the filename given by the client is valid,
meaning that no invalid characters (null-bytes) are added and that the file
does not contain an invalid file extension. The API has support for custom
validators, which can be created on demand.

To avoid complexity and maintain data integrity, a file upload is only
processed if the validation of all properties of a domain model is successful.
In this first implementation, file uploads are not persisted/cached temporarily,
so this means in any case of a validation failure ("normal" validators and file upload
validation) a file upload must be performed again by users.

Possible future enhancements of this functionality could enhance the existing
`#[FileUpload]` attribute/annotation with configuration like a temporary storage
location, or specifying additional custom validators (which can be done via the PHP-API as
described below)

..  _extbase_fileupload_attribute_configuration:
File upload configuration with the `FileUpload` attribute
---------------------------------------------------------

File upload for a property of a domain model can be configured using the
newly introduced :php:`\TYPO3\CMS\Extbase\Annotation\FileUpload` attribute.

Example:

..  literalinclude:: _FileUpload/_BlogExcerpt.php
    :caption: EXT:my_extension/Classes/Domain/Model/Blog.php (example excerpt of an Extbase domain model)
    :emphasize-lines: 13-21

All configuration settings of the
:php:`\TYPO3\CMS\Extbase\Mvc\Controller\FileUploadConfiguration` object can
be defined using the :php-short:`\TYPO3\CMS\Extbase\Annotation\FileUpload`
attribute. It is however not possible
to add custom validators using the
:php-short:`\TYPO3\CMS\Extbase\Annotation\FileUpload` attribute, which you
can achieve with a manual configuration as shown below.

The currently available configuration array keys are:

*   `validation` (:php:`array` with keys `required`, `maxFiles`, `minFiles`,
    `fileSize`, `allowedMimeTypes`, `imageDimensions`, see
    :ref:`extbase_fileupload_attribute-validationkeys`)
*   `uploadFolder` (:php:`string`, destination folder)
*   `duplicationBehavior` (:php:`object`, behaviour when file exists)
*   `addRandomSuffix` (:php:`bool`, suffixing files)
*   `createUploadFolderIfNotExist` (:php:`bool`, whether to create missing
    directories)

It is also possible to use the :php-short:`\TYPO3\CMS\Extbase\Annotation\FileUpload` annotation to configure
file upload properties, but it is recommended to use the
:php-short:`\TYPO3\CMS\Extbase\Annotation\FileUpload` attribute due to better readability.

..  _extbase_fileupload_attribute-manual-configuration:

Manual file upload configuration
--------------------------------

A file upload configuration can also be created manually and should be
done in the :php:`initialize*Action`.

Example:

..  code-block:: php
    :caption: Excerpt of an Extbase controller class

    public function initializeCreateAction(): void
    {
        $mimeTypeValidator = GeneralUtility::makeInstance(MimeTypeValidator::class);
        $mimeTypeValidator->setOptions(['allowedMimeTypes' => ['image/jpeg']]);

        $fileHandlingServiceConfiguration = $this->arguments->getArgument('myArgument')->getFileHandlingServiceConfiguration();
        $fileHandlingServiceConfiguration->addFileUploadConfiguration(
            (new FileUploadConfiguration('myPropertyName'))
                ->setRequired()
                ->addValidator($mimeTypeValidator)
                ->setMaxFiles(1)
                ->setUploadFolder('1:/user_upload/files/')
        );

        $this->arguments->getArgument('myArgument')->getPropertyMappingConfiguration()->skipProperties('myPropertyName');
    }


..  _extbase_fileupload_attribute-options:

Configuration options for file uploads
--------------------------------------

The configuration for a file upload is defined in a
:php:`FileUploadConfiguration` object.

This object contains the following configuration options.

..  hint::

    The appropriate setter methods or configuration
    keys can best be inspected inside that class definition.

..  _extbase_fileupload_attribute-property-name:

Property name:
~~~~~~~~~~~~~~

Defines the name of the property of a domain model to which the file upload
configuration applies. The value is automatically retrieved when using
the :php-short:`\TYPO3\CMS\Extbase\Annotation\FileUpload` attribute. If the
:php-short:`\TYPO3\CMS\Extbase\Mvc\Controller\FileUploadConfiguration` object
is created manually, it must be set using the :php:`$propertyName`
constructor argument.

..  _extbase_fileupload_attribute-validation:

Validation:
~~~~~~~~~~~

File upload validation is defined in an array of validators in the
:php-short:`\TYPO3\CMS\Extbase\Mvc\Controller\FileUploadConfiguration` object. The validator
:php:`\TYPO3\CMS\Extbase\Validation\Validator\FileNameValidator`,
which ensures that no executable PHP files can
be uploaded, is added by default if the file upload configuration object
is created using the
:php-short:`\TYPO3\CMS\Extbase\Annotation\FileUpload` attribute.

In addition, Extbase includes the following validators to validate an
:php-short:`\TYPO3\CMS\Core\Http\UploadedFile` object:

*   :php:`\TYPO3\CMS\Extbase\Validation\Validator\FileSizeValidator`
*   :php:`\TYPO3\CMS\Extbase\Validation\Validator\MimeTypeValidator`
*   :php:`\TYPO3\CMS\Extbase\Validation\Validator\ImageDimensionsValidator`

Those validators can either be configured with the
:php-short:`\TYPO3\CMS\Extbase\Annotation\FileUpload` attribute or added
manually to the configuration object
with the :php:`addValidator()` method.

..  _extbase_fileupload_attribute-required:

Required
~~~~~~~~

Defines whether a file must be uploaded. If it is set to `true`, the
:php:`minFiles` configuration is set to `1`.

..  _extbase_fileupload_attribute-minimum-files:

Minimum files
~~~~~~~~~~~~~

Defines the minimum amount of files to be uploaded.

..  _extbase_fileupload_attribute-maximum-files:

Maximum files
~~~~~~~~~~~~~

Defines the maximum amount of files to be uploaded.

..  _extbase_fileupload_attribute-upload-folder:

Upload folder
~~~~~~~~~~~~~

Defines the upload path for the file upload. This configuration expects a
storage identifier (e.g. :php:`1:/user_upload/folder/`). If the given target
folder in the storage does not exist, it is created automatically.

..  _extbase_fileupload_attribute-upload-folder-creation:

Upload folder creation, when missing
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The default creation of a missing storage folder can be disabled via the
property :php:`createUploadFolderIfNotExist` of the :php:`#[FileUpload([...])]` attribute
(:php:`bool`, default :php:`true`).

..  _extbase_fileupload_attribute-random-suffix:

Add random suffix
~~~~~~~~~~~~~~~~~

When enabled, the filename of an uploaded and persisted file will contain a
random 16 char suffix. As an example, an uploaded file named
:php:`job-application.pdf` will be persisted as
:php:`job-application-<random-hash>.pdf` in the upload folder.

The default value for this configuration is :php:`true` and it is recommended
to keep this configuration active.

This configuration only has an effect when uploaded files are persisted.

..  _extbase_fileupload_attribute-duplication-behavior:

Duplication behavior
~~~~~~~~~~~~~~~~~~~~

Defines the FAL behavior, when a file with the same name exists in the target
folder. Possible values are
:php-short:`\TYPO3\CMS\Core\Resource\Enum\DuplicationBehavior::RENAME` (default),
:php-short:`\TYPO3\CMS\Core\Resource\Enum\DuplicationBehavior::REPLACE` and
:php-short:`\TYPO3\CMS\Core\Resource\Enum\DuplicationBehavior::CANCEL`.


..  _extbase_fileupload_attribute-configuration-change:

Modifying existing configuration
--------------------------------

File upload configuration defined by the
:php-short:`\TYPO3\CMS\Extbase\Annotation\FileUpload` attribute can be
changed in the :php:`initialize*Action`.

Example:

..  code-block:: php
    :caption: Excerpt of an Extbase controller class

    public function initializeCreateAction(): void
    {
        $validator = GeneralUtility::makeInstance(MyCustomValidator::class);

        $argument = $this->arguments->getArgument('myArgument');
        $configuration = $argument->getFileHandlingServiceConfiguration()->getFileUploadConfigurationForProperty('file');
        $configuration?->setMinFiles(2);
        $configuration?->addValidator($validator);
        $configuration?->setUploadFolder('1:/user_upload/custom_folder');
    }

The example shows how to modify the file upload configuration for the argument
:php:`item` and the property :php:`file`. The minimum amount of files to be
uploaded is set to :php:`2` and a custom validator is added.

To remove all defined validators except the :php:`DenyPhpUploadValidator`, use
the :php:`resetValidators()` method.


..  _extbase_fileupload_attribute-typoscript:

Using TypoScript configuration for file uploads configuration
-------------------------------------------------------------

When a file upload configuration for a property has been added using the
:php-short:`\TYPO3\CMS\Extbase\Annotation\FileUpload` attribute, it may be
required make the upload folder or
other configuration options configurable with TypoScript.

Extension authors should use the :php:`initialize*Action` to apply settings
from TypoScript to a file upload configuration.


Example:

..  code-block:: php
    :caption: Exercept of an Extbase controller class

    public function initializeCreateAction(): void
    {
        $argument = $this->arguments->getArgument('myArgument');
        $configuration = $argument->getFileHandlingServiceConfiguration()->getConfigurationForProperty('file');
        $configuration?->setUploadFolder($this->settings['uploadFolder'] ?? '1:/fallback_folder');
    }


..  _extbase_fileupload_attribute-validationkeys:

File upload validation
----------------------

Each uploaded file can be validated against a configurable set of validators.
The :php:`validation` section of the :php-short:`\TYPO3\CMS\Extbase\Annotation\FileUpload` attribute allows to
configure commonly used validators using a configuration shorthand.

The following validation rules can be configured in the :php:`validation`
section of the :php-short:`\TYPO3\CMS\Extbase\Annotation\FileUpload` attribute:

*   :php:`required`
*   :php:`minFiles`
*   :php:`maxFiles`
*   :php:`fileSize`
*   :php:`allowedMimeTypes`
*   :php:`imageDimensions`

Example:

..  code-block:: php
    :caption: Excerpt of an attribute withhin an Extbase domain model class

    #[FileUpload([
        'validation' => [
            'required' => true,
            'maxFiles' => 1,
            'fileSize' => ['minimum' => '0K', 'maximum' => '2M'],
            'allowedMimeTypes' => ['image/jpeg'],
            'imageDimensions' => ['maxWidth' => 4096, 'maxHeight' => 4096]
        ],
        'uploadFolder' => '1:/user_upload/extbase_single_file/',
    ])]

Extbase will internally use the Extbase file upload validators for
:php:`fileSize`, :php:`allowedMimeTypes` and :php:`imageDimensions` validation.

Custom validators can be created according to project requirements and must
extend the Extbase :php-short:`\TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator`.
The value to be validated is
always a PSR-7 :php-short:`\TYPO3\CMS\Core\Http\UploadedFile` object.
Custom validators can however not
be used in the :php-short:`\TYPO3\CMS\Extbase\Annotation\FileUpload` attribute
and must be configured manually.


..  _extbase_fileupload_attribute-deletion:

Deletion of uploaded files and file references
----------------------------------------------

The new Fluid ViewHelper
:ref:`Form.uploadDeleteCheckbox ViewHelper <f:form.uploadDeleteCheckbox> <t3viewhelper:typo3-fluid-form-uploaddeletecheckbox>`
can be used to show a "delete file" checkbox in a form.

Example for object with :php-short:`\TYPO3\CMS\Core\Resource\FileReference` property:

..  code-block:: php
    :caption: Fluid code example

    <f:form.uploadDeleteCheckbox property="file" fileReference="{object.file}" />

Example for an object with an :php:`ObjectStorage<FileReference>` property,
containing multiple files and allowing to delete the first one
(iteration is possible within Fluid, to do that for every object of the collection):

..  code-block:: php
    :caption: Fluid code example

    <f:form.uploadDeleteCheckbox property="file.0" fileReference="{object.file}" />

Extbase will then handle file deletion(s) before persisting a validated
object. It will:

*   validate that minimum and maximum file upload configuration for the affected
    property is fulfilled (only if the property has a :php-short:`\TYPO3\CMS\Extbase\Annotation\FileUpload`)
*   delete the affected :php:`sys_file_reference` record
*   delete the affected file

Internally, Extbase uses :php:`FileUploadDeletionConfiguration` objects to track
file deletions for properties of arguments. Files are deleted directly without
checking whether the current file is referenced by other objects.

Apart from using this ViewHelper, it is of course still possible to manipulate
:php-short:`\TYPO3\CMS\Core\Resource\FileReference` properties with custom logic before persistence.

..  _extbase_fileupload_attribute-psr-event:

ModifyUploadedFileTargetFilenameEvent
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The :php-short:`\TYPO3\CMS\Extbase\Event\Service\ModifyUploadedFileTargetFilenameEvent`
allows event listeners to
alter a filename of an uploaded file before it is persisted.

Event listeners can use the method `getTargetFilename()` to retrieve the filename
used for persistence of a configured uploaded file. The filename can then be
adjusted via `setTargetFilename()`. The relevant configuration can be retrieved
via `getConfiguration()`.

..  _extbase_fileupload_multistep:

Multi-step form handling
------------------------

The implementation of the file upload feature in Extbase intentionally requires to
handle the FileUpload directly within the validation/persistence step of a controller
action.

If you have a multi-step process in place, where the final persistence of a domain model
object is only performed later on, you will need to deal with the created files.

For example, you may want to implement a preview before the final domain model
entity is persisted.

Some possible ways to deal with this:

*   Implement the file handling as a :ref:`DTO <concept-dto>`. The key idea here is
    to decouple the uploaded file into its own domain model object. You can pass that
    along (including its persistence identity) from one form step to the next, and only
    in the final step you would take care of transferring the data of this DTO into
    your actual domain model, and attach the `FileReference` object.

*   Or use client-side JavaScript. You could create a stub in your Fluid template that
    has placeholders for user-specified data, and then fills the actual data (before
    the form is submitted) into these placeholders. You can use the JavaScript :js:`FileReader()`
    object to access and render uploaded files.
