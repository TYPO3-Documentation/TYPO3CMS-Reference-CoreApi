:navigation-title: Model extensions

.. include:: /Includes.rst.txt

.. _extending-extbase-model:

==========================
Extending an Extbase model
==========================

Once you have added a new field to the
:ref:`TCA <extending-tca>` it will be displayed in the backend forms.

However, if the extension you are trying to extend is based on :ref:`Extbase <extbase>` the new
field is not available in the frontend out of the box. Further steps are
needed to make the fields available. These steps will not work in all cases.

.. _extending-extbase-model_quick_overview:

Quick overview
==============

Follow these steps:

..  rst-class:: bignums

#.  Is your extension the :ref:`only extension trying to
    extend <extending-extbase-model_find_other_extending_models>` the original
    model in your installation?

#.  :ref:`Find the original model <extending-extbase-model_find_original_model>`.
    If the model has the :php:`final` modifier, refer
    to the extension documentation on how to display additional fields.

#.  :ref:`Find the original repository <extending-extbase-model_find_original_repository>`.
    If the repository is :php:`final`, refer
    to the extension documentation on how to display additional fields.

#.  :ref:`Extend the original model <extending-extbase-model_extend_original_model>`
    in your extension or :ref:`sitepackage <site-package>`.

#.  :ref:`Register your extended model <extending-extbase-model_register_extended_model>`
    with the corresponding database table in
    :file:`EXT:my_extension/Configuration/Extbase/Persistence/Classes.php`.

#.  :ref:`Extend the original repository <extending-extbase-model_register_extended_model>`
    in your extension or sitepackage.

#.  :ref:`Register your extended repository <extending-extbase-model_register_extended_repository>`
    so that it is used instead of the original one.

.. _extending-extbase-model_steps:

Step by step
============

..  _extending-extbase-model_find_other_extending_models:

Are you the only one trying to extend that model?
-------------------------------------------------

Search for other classes in your installation that extend
the original model or repository (see below).

If the model is already extended but you only need to create the fields for
your current installation you can proceed by extending the extended model.
In the rest of this tutorial use the extended model
as the original model.

If the model has different :ref:`record types <extbase-persistance-record-types>`
you can add a new type and
only extend that one type. This is commonly done when extending
the :composer:`georgringer/news` model.

If you are planning to publish this extension, search
`Packagist <https://packagist.org/>`__ and the
`TER (TYPO3 extension repository) <https://extensions.typo3.org/>`__ for
extensions that also extend the original model. If necessary, put them in
the `conflict` sections of your extension's :ref:`composer-json` and
:ref:`ext_emconf-php`.

..  _extending-extbase-model_find_original_model:

Finding the original model
--------------------------

The model should be located in the original extension in
:file:`EXT:original_extension/Classes/Domain/Model/` or a subdirectory. If the
model is not there it might:

*   be located in a different extension
*   not be an Extbase model (then you cannot follow this tutorial)

You can also try debugging the model with a Fluid template that outputs the model:

..  code-block:: html
    :caption: Some Fluid template that uses the model

    <f:debug>{someModel}</f:debug>

If you debugged the correct object, the fully qualified PHP name of the model
will appear in the debug output. This will give you further hints on where to find
the associated class. You could, for example, do a full text search for the
namespace of the class.

If the class of the model is final:

..  code-block:: php
    :caption: EXT:original_extension/Classes/Domain/Model/SomeModel.php

    final class SomeModel {
        // ...
    }

it cannot be extended using the instructions in this tutorial. Refer to the documentation of
the original extension.

..  _extending-extbase-model_find_original_repository:

Finding the original repository
-------------------------------

In Extbase the repository of a model usually has the same class name as
the model, prefixed with "Repository". It is located in the same domain
directory as the model, but in the :file:`Repository` subfolder.

For example, if the model is :file:`Classes/Domain/Model/SomeModel.php`
the repository is located in
:file:`Classes/Domain/Repository/SomeModelRepository.php`.

*   If you can't find the repository but have found the model, the extension might
    not be using an Extbase repository. This tutorial will not help you in this
    case as it is only relevant for Extbase repositories.
*   If you find a repository according to this naming scheme but it does not extend
     the class
    :php:`TYPO3\CMS\Extbase\Persistence\Repository` directly or indirectly, it
    is also not an Extbase repository.
*   If the repository is final it cannot be extended.

In all these cases refer to the extension documentation on how to extend it.

..  _extending-extbase-model_extend_original_model:

Extend the original model
-------------------------

We assume that you have already extended the database table and TCA (table
configuration array) as described in :ref:`Extending TCA <extending-tca>`. Extend the
original model in your extension using a class:

..  literalinclude:: _MyExtendedModel.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Model/MyExtendedModel.php

Add all the additional fields that you require. By convention the database
fields and the model names are prefixed with the name of your extension.

..  _extending-extbase-model_register_extended_model:

Register the extended model
---------------------------

The extended model needs to be registered for :ref:`Extbase persistence <extbase-Persistence>` in files
:file:`Configuration/Extbase/Persistence/Classes.php` and :file:`ext_localconf.php`.

..  literalinclude:: _Classes.php
    :language: php
    :caption: EXT:my_extension/Configuration/Extbase/Persistence/Classes.php

..  literalinclude:: _ext_localconf.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

..  _extending-extbase-model_extend_original_repository:

Extend the original repository (optional)
-----------------------------------------

Similarly, extend the original repository:

..  literalinclude:: _MyExtendedModelRepository.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyExtendedModelRepository.php

The rule that a repository must follow the naming schema of the model also
applies when extending model and repository. So the new repository's name must
end with "Repository" and it must be in the :file:`Domain/Repository` directory.

If you don't need additional repository methods you can leave the body of
this class empty. However, for internal Extbase reasons you have to create the
repository even if you don't add additional functionality.

..  _extending-extbase-model_register_extended_repository:

Register the extended repository
--------------------------------

The extended repository needs to be registered with Extbase in your extension file
:file:`EXT:my_extension/ext_localconf.php`. This tells
Extbase to use your repository instead of the original one whenever the original
repository is requested via Dependency Injection in a controller or service.

..  literalinclude:: _ext_localconf_repository.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

..  _extending-extbase-model_alternative_strategies:

Alternative strategies to extend Extbase models
===============================================

There is a TYPO3 extension that extends models and functions to classes by
implementing the proxy pattern: `Extbase Domain Model Extender
(evoweb/extender) <https://extensions.typo3.org/extension/extender>`__.

This extension can be used to
:ref:`extend models of tt_address <friendsoftypo3/tt-address:development-extend-ttaddress>`, for example.

The popular extension `EXT:news (georgringer/news)` has a special
generator that can be used to :ref:`add new fields to news models
<georgringer/news:proxyClassGenerator>`.
