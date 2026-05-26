:navigation-title: File upload

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; File upload
..  _extbase-domain-fileupload:

======================================
File uploads in Extbase domain models
======================================

Extbase can handle file uploads automatically as part of its normal property
mapping and persistence flow, using the
:ref:`FAL (File Abstraction Layer) <t3coreapi:using-fal>` for storage.
Two distinct topics are covered here: reading existing
:php-short:`\TYPO3\CMS\Core\Resource\FileReference` properties from a domain
model, and writing newly uploaded files using the :php:`#[FileUpload]`
attribute.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-domain-fileupload-reading:

Reading a file reference from a domain model
============================================

Reading an existing file reference requires two components: the model property
and the corresponding TCA column definition.

The domain model:

..  literalinclude:: _FileUpload/_Conference.php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

The TCA definition:

..  literalinclude:: _FileUpload/_tx_myextension_domain_model_conference.php
    :caption: EXT:my_extension/Configuration/TCA/tx_myextension_domain_model_conference.php

Once a record has files attached via the TYPO3 backend, the controller
retrieves them through the standard Extbase getters and the Fluid template
renders them:

..  literalinclude:: _FileUpload/_Show.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/Show.fluid.html


..  _extbase-domain-fileupload-writing:

Writing uploaded files with :php:`#[FileUpload]`
================================================

The :php:`\TYPO3\CMS\Extbase\Attribute\FileUpload` attribute on a model
property is all that is needed to wire up upload processing. Extbase validates
the upload, moves the file into the configured
:abbr:`FAL (File Abstraction Layer)` storage folder, and creates the
:php-short:`\TYPO3\CMS\Core\Resource\FileReference` record — all
automatically, after property mapping succeeds.

The domain model with :php:`#[FileUpload]` on both properties:

..  literalinclude:: _FileUpload/_ConferenceWithUpload.php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

The TCA definition is identical to the read-only case above — no special TCA
configuration is required for upload handling.

The upload form must declare :html:`enctype="multipart/form-data"` and use
:ref:`f:form.upload <t3viewhelper:typo3-fluid-form-upload>` for each file
property:

..  literalinclude:: _FileUpload/_New.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/New.fluid.html

The controller actions require no special upload code. Extbase handles
everything between property mapping and persistence. The only requirement is
that the model is persisted within the same request:

..  literalinclude:: _FileUpload/_ConferenceController.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

..  important::

    The model must be persisted (via :php:`$conferenceRepository->add()` or
    :php:`$conferenceRepository->update()`) in the same request that processes
    the upload. Without persistence, dangling :sql:`sys_file` records are
    created without a corresponding :php:`FileReference`, leaving stale
    temporary files that require manual cleanup.

Upload processing runs after property mapping completes. If any model property
fails validation, the file is not uploaded and the user must re-upload on the
next attempt. This avoids stale temporary files.

..  note::

    File upload handling for nested domain models — for example
    :php:`conferenceA.speaker.photo` — is not supported. The
    :php:`#[FileUpload]` attribute must be placed on a property of the model
    that is the direct argument of the action.


..  _extbase-domain-fileupload-attribute:

Configuring the :php:`#[FileUpload]` attribute
==============================================

The :php:`#[FileUpload]` attribute accepts named arguments:

:php:`validation`
    Array configuring built-in file upload validators. See
    :ref:`extbase-domain-fileupload-validation` below.

:php:`uploadFolder`
    Destination as a FAL storage path, for example
    :php:`'1:/user_upload/conference_logos/'`. The folder is created
    automatically unless :php:`createUploadFolderIfNotExist` is set to
    :php:`false`.

:php:`createUploadFolderIfNotExist`
    :php:`bool`, default :php:`true`.

:php:`addRandomSuffix`
    :php:`bool`, default :php:`true`. Appends a random 16-character hash to
    the persisted filename to prevent enumeration. Recommended to keep enabled.

:php:`duplicationBehavior`
    FAL behaviour when a file with the same name already exists in the target
    folder:
    :php-short:`\TYPO3\CMS\Core\Resource\Enum\DuplicationBehavior::RENAME`
    (default),
    :php-short:`\TYPO3\CMS\Core\Resource\Enum\DuplicationBehavior::REPLACE`,
    or
    :php-short:`\TYPO3\CMS\Core\Resource\Enum\DuplicationBehavior::CANCEL`.


..  _extbase-domain-fileupload-validation:

File upload validation
======================

Two validators are enforced automatically for every :php:`#[FileUpload]`
property and cannot be removed:

*   :ref:`extbase-validation-builtin-filename` — rejects files whose name
    matches dangerous executable extensions such as :file:`.php` or
    :file:`.phar`. This is a hard security boundary; there is no legitimate
    reason to bypass it.
*   :ref:`extbase-validation-builtin-fileextensionmimetypeconsistency` —
    cross-checks that the file extension and the detected MIME type are
    consistent, guarding against disguised uploads such as a PHP script renamed
    to :file:`image.jpg`.

Beyond these two, the :php:`validation` array configures additional validators
via shorthand keys. The most important ones to configure on any public upload
form are:

**fileSize** — always set a meaningful lower and upper bound. A minimum of
:php:`'10K'` rejects empty or near-empty files that would otherwise pass
silently. An upper bound prevents storage exhaustion:

..  code-block:: php
    :caption: fileSize example

    'fileSize' => ['minimum' => '10K', 'maximum' => '2M'],

**mimeType** — restricts accepted content types by inspecting the actual file
content, not just the name. Always combine with :php:`fileExtension` to cover
both the client-supplied extension and the server-detected type:

..  code-block:: php
    :caption: mimeType example

    'mimeType' => ['allowedMimeTypes' => ['image/jpeg', 'image/png']],

**fileExtension** — validates the file extension as supplied by the client.
The ``allowedFileExtensions`` list should match ``allowedMimeTypes`` exactly:

..  code-block:: php
    :caption: fileExtension example

    'fileExtension' => ['allowedFileExtensions' => ['jpg', 'jpeg', 'png']],

**imageDimensions** — for image uploads, caps width and height to prevent
oversized images from reaching the server's image processing pipeline:

..  code-block:: php
    :caption: imageDimensions example

    'imageDimensions' => ['maxWidth' => 4096, 'maxHeight' => 4096],

The remaining keys — ``required``, ``minFiles``, ``maxFiles`` — control
upload count. For the full option reference see
:ref:`extbase-validation-builtin-file`.

..  warning::

    Keep the allowed MIME types and file extensions configured in
    :php:`#[FileUpload]` in sync with the :ref:`TCA type=file 'allowed' key
    <t3tca:columns-file>` on the same column. If they diverge, a file accepted
    by the frontend form may be rejected by the TYPO3 backend, or a file
    uploaded through the backend may not match the frontend validation rules.
    Either mismatch leads to confusing behaviour that is hard to debug. Define
    the allowed types once, in both places.

    Also set the same list on :html:`<f:form.upload accept="...">` so the
    browser's file picker pre-filters the selectable types for a better user
    experience — though this is a client-side hint only and not a security
    control.


..  _extbase-domain-fileupload-manual:

Manual file upload configuration
================================

When :php:`#[FileUpload]` is not flexible enough — for example to add a custom
validator class — create a
:php:`\TYPO3\CMS\Extbase\Mvc\Controller\FileUploadConfiguration` object
manually in an :php:`initialize*Action()`:

..  literalinclude:: _FileUpload/_ConferenceControllerManual.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php (excerpt)

Note the :php:`skipProperties()` call: Extbase's property mapping must not
operate on the file property when manual upload configuration is used.
The :php:`#[FileUpload]` attribute handles this internally; with manual
configuration it must be done explicitly.

To modify configuration already defined by :php:`#[FileUpload]` — for example
to read the upload folder from TypoScript settings — retrieve the existing
configuration object instead of creating a new one:

..  code-block:: php
    :caption: Applying TypoScript settings to the upload folder

    public function initializeCreateAction(): void
    {
        $argument = $this->arguments->getArgument('conference');
        $configuration = $argument
            ->getFileHandlingServiceConfiguration()
            ->getFileUploadConfigurationForProperty('logo');
        $configuration?->setUploadFolder(
            $this->settings['logoUploadFolder'] ?? '1:/user_upload/conference_logos/',
        );
    }

To strip all application-level validators and start from a clean slate, call
:php:`$configuration->resetValidators()`. The two mandatory validators
(:ref:`extbase-validation-builtin-filename` and
:ref:`extbase-validation-builtin-fileextensionmimetypeconsistency`) are always
re-added and cannot be removed. Calling :php:`resetValidators()` on a
public-facing upload form without immediately adding back type and size
restrictions leaves the upload open to any file content — do this only when
you have a deliberate, application-specific reason and compensate with other
controls.


..  _extbase-domain-fileupload-deletion:

Deleting uploaded files
=======================

The
:ref:`f:form.uploadDeleteCheckbox <t3viewhelper:typo3-fluid-form-uploaddeletecheckbox>`
ViewHelper renders a :guilabel:`Delete file` checkbox. When submitted, Extbase
deletes the :sql:`sys_file_reference` record and the underlying file before
persisting the updated model:

..  literalinclude:: _FileUpload/_Edit.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/Edit.fluid.html

..  warning::

    Extbase deletes the file directly from
    :abbr:`FAL (File Abstraction Layer)` **without checking whether any other
    record references the same file**. This is different from the TYPO3 backend,
    which prevents deletion of files that still have consumers. If the same
    :php-short:`\TYPO3\CMS\Core\Resource\FileReference` is referenced by
    multiple domain objects, deleting it through this mechanism will break the
    other references silently. Ensure files are not shared before enabling
    deletion.


..  _extbase-domain-fileupload-event:

Modifying the target filename before persistence
================================================

:php-short:`\TYPO3\CMS\Extbase\Event\Service\ModifyUploadedFileTargetFilenameEvent`
allows event listeners to alter the filename of an uploaded file before it is
written to :abbr:`FAL (File Abstraction Layer)`. Use :php:`getTargetFilename()`
to read the current name and :php:`setTargetFilename()` to replace it. The
active :php:`FileUploadConfiguration` is available via
:php:`getConfiguration()`.


..  _extbase-domain-fileupload-multistep:

File uploads in multi-step forms
================================

Extbase file upload handling is coupled to the persistence step of a single
action. If a multi-step form must carry file state across requests before final
persistence, two patterns work:

*   **DTO approach** — persist the uploaded file as a standalone domain object
    (or a dedicated DTO with its own :php:`FileReference`) in the first step.
    Pass its :php:`uid` as a hidden field through subsequent steps. In the
    final step, attach the :php:`FileReference` to the actual domain model.

*   **Client-side preview** — use the JavaScript :js:`FileReader()` API to
    render a preview of the selected file in the browser before the form is
    submitted, without a server round-trip.


..  seealso::

    *   :ref:`extbase-validation-builtin-file` — full reference for all
        file upload validators and their options.
    *   :ref:`t3coreapi:using-fal` — the File Abstraction Layer in TYPO3.
