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

..  versionchanged:: 13.3
    With TYPO3 v13.3
    :ref:`Feature: #103511 - Introduce Extbase file upload and deletion handling <changelog:feature-103511-1711894330>`
    was introduced and allows a simplified file upload handling. See
    :ref:`<t3coreapi/13:extbase_fileupload_writing-manual>` for details.

With TYPO3 versions 12.4 and below, attaching files to an Extbase domain model
is only possible by either:

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
