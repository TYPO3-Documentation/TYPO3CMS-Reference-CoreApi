:navigation-title: Model extensions

.. include:: /Includes.rst.txt

.. _extending-extbase-model:

==========================
Extending an Extbase model
==========================

Once you have added an additional field to the
:ref:`TCA <extending-tca>` the new field will be displayed in the backend forms.

However, if the extension you are trying to extend is based on :ref:`Extbase <extbase>` the new
field is not available in the frontend out of the box. Further steps are
needed to make the fields available. These steps will not work in all cases.

Quick overview
==============

Follow these steps:

..  rst-class:: bignums

#.  Is your extension the :ref:`only one trying to
    extend <extending-extbase-model_find_other_extending_models>` the original
    model within your installation?

#.  :ref:`Find the original model <extending-extbase-model_find_original_model>`.
    If this model has the modifier :php:`final` refer
    to the extension's documentation on how to display additional fields.

#.  :ref:`Find the original repository <extending-extbase-model_find_original_repository>`.
    Again, if the repository is :php:`final` refer
    to the extension's documentation on how to display additional fields.

#.  :ref:`Extend the original model <extending-extbase-model_extend_original_model>`
    in your custom extension or :ref:`sitepackage <site-package>`.

#.  :ref:`Register your extended model <extending-extbase-model_register_extended_model>`
    with the according database table in
    :file:`EXT:my_extension/Configuration/Extbase/Persistence/Classes.php`.

#.  :ref:`Extend the original repository <extending-extbase-model_register_extended_model>`
    in your custom extension or sitepackage.

#.  :ref:`Register your extended repository <extending-extbase-model_register_extended_repository>`
    to be used instead of the original one.

Step by step
============

..  _extending-extbase-model_find_other_extending_models:

Are you the only one trying to extend that model?
-------------------------------------------------

Within your installation you can search for other classes that are extending
the original model or repository (see below).

If the model is already extended but you only need to create the fields for
your current installation you can proceed by extending the extended model.
In the following steps of this tutorial use the previously extended model
as original model.

If the model has different :ref:`Record types <extbase-persistance-record-types>`
you can decide to introduce a new type and
only extend that one type. This is, for example, commonly done when extending
the model of :t3ext:`news`.

If you are planning to publish your extension that extends another extensions
model, research on `Packagist <https://packagist.org/>`__ and the
`TER (TYPO3 extension repository) <https://extensions.typo3.org/>`__ for
extensions that are already extending the model. If necessary, put them in
the `conflict` sections of you extensions :ref:`composer-json` and
:ref:`ext_emconf-php`.

..  _extending-extbase-model_find_original_model:

Find the original model
-----------------------

The model should be located in the original extension at path
:file:`EXT:original_extension/Classes/Domain/Model/` or a subdirectory
thereof. If the model is not found here it might

*   be situated in a different extension
*   not be an Extbase model (you cannot follow this tutorial then)

You can also try to debug the model in a Fluid template that outputs the model:

..  code-block:: html
    :caption: Some Fluid template that uses the model

    <f:debug>{someModel}</f:debug>

If you debugged the correct object the fully qualified PHP name of the model
will appear in the debug output. This gives you further hints on where to find
the associated class. You could, for example, do a full text search for the
namespace of this class.

If the class of the model is final:

..  code-block:: php
    :caption: EXT:original_extension/Classes/Domain/Model/SomeModel.php

    final class SomeModel {
        // ...
    }

It cannot be extended by means of this tutorial. Refer to the documentation of
the original extension.

..  _extending-extbase-model_find_original_repository:

Find the original repository
----------------------------

In Extbase the repository of a model mostly has to have the same class name as
the model, prefixed with "Repository". It has to be located in the same domain
directory as the model, but in the subfolder :file:`Repository`.

For example, if the model is found in :file:`Classes/Domain/Model/SomeModel.php`
the repository is located in
:file:`Classes/Domain/Repository/SomeModelRepository.php`.

*   If you do not find this repository but found the model the extension might
    not use an Extbase repository. This tutorial does not help you in this
    case as it can only be applied to Extbase repositories.
*   If you find a repository in this name scheme but it does not extend
    directly or indirectly the class
    :php:`TYPO3\CMS\Extbase\Persistence\Repository` you are also not dealing
    with an Extbase repository.
*   If the repository is final it cannot be extended.

In all these cases refer to the extension's documentation on how to extend it.

..  _extending-extbase-model_extend_original_model:

Extend the original model
-------------------------

We assume you already extended the database table and TCA (table configuration array)
as described in :ref:`Extending TCA <extending-tca>`. Extend the
original model by a custom class in your extension:

..  literalinclude:: _MyExtendedModel.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Model/MyExtendedModel.php

Add all additional fields that you require. By convention the database
fields are usually prefixed with your extension's name and so are the
names in the model.

..  _extending-extbase-model_register_extended_model:

Register the extended model
---------------------------

The extended model needs to be registered for :ref:`Extbase persistence <extbase-Persistence>` in file
:file:`Configuration/Extbase/Persistence/Classes.php` and :file:`ext_localconf.php`.

..  literalinclude:: _Classes.php
    :language: php
    :caption: EXT:my_extension/Configuration/Extbase/Persistence/Classes.php

..  literalinclude:: _ext_localconf.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

..  _extending-extbase-model_extend_original_repository:

Extend the original repository
------------------------------

Likewise extend the original repository:

..  literalinclude:: _MyExtendedModelRepository.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/MyExtendedModelRepository.php

The rule that a repository must follow the name schema of the model also
applies when extending model and repository. So the new repository's name must
end on "Repository" and it must be in the directory :file:`Domain/Repository`.

If you have no need for additional repository methods you can leave the body of
this class empty. However, for Extbase internal reasons you have to create this
repository even if you need no additional functionality.

..  _extending-extbase-model_register_extended_repository:

Register the extended repository
--------------------------------

The extended repository needs to be registered with Extbase in your extensions
:file:`EXT:my_extension/ext_localconf.php`. This step tells
Extbase to use your repository instead of the original one whenever the original
repository is requested via Dependency Injection in a controller or service.

..  literalinclude:: _ext_localconf_repository.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

Alternative strategies to extend Extbase models
===============================================

There is a dedicated TYPO3 extension to extend models and functions to classes by
implementing the proxy pattern: `Extbase Domain Model Extender
(evoweb/extender) <https://extensions.typo3.org/extension/extender>`__.

This extension can - for example - be used to
:ref:`Extend models of tt_address <friendsoftypo3/tt-address:development-extend-ttaddress>`.

The commonly used extension `EXT:news (georgringer/news)` supplies a special
generator that can be used to :ref:`add custom fields to news models
<georgringer/news:proxyClassGenerator>`.
