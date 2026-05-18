.. include:: /Includes.rst.txt
.. index:: User settings; Custom settings
.. _user-settings-extending:

===========================
Extending the user settings
===========================

Custom user settings are configured in the TCA of the
:php:`be_users` table using the column
:php:`user_settings`.

Extensions should use
:php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserSetting()`
to register additional fields.

All configuration must be placed in:

:file:`Configuration/TCA/Overrides/be_users.php`

Adding a custom user setting
============================

The recommended way to add a custom user setting is:

.. literalinclude:: _be_users_override.php
   :language: php
   :caption: EXT:my_ext/Configuration/TCA/Overrides/be_users.php

The method accepts three arguments:

1. **Field name**

   A unique identifier for the user setting.

2. **Field configuration**

   A TCA configuration array defining the setting.
   The array must contain:

   * :php:`label` – The field label (string or LLL reference)
   * :php:`config` – A standard TCA :php:`config` array
   * :php:`table` – (optional) Set to :php:`'be_users'` if the value
     is stored in a dedicated database column of the
     :php:`be_users` table.

3. **Position (optional)**

   A positioning instruction defining where the field
   should appear within the user settings form,
   for example:

   * :code:`after:fieldName`
   * :code:`before:fieldName`

Alternatively: Direct TCA modification
======================================

Extensions can also directly modify the TCA definition of
:php:`user_settings`:

.. literalinclude:: _be_users_direct_tca.php
   :language: php
   :caption: EXT:my_ext/Configuration/TCA/Overrides/be_users.php

When modifying TCA directly, the field must be added to both:

* the :php:`columns` array
* the :php:`showitem` configuration

Structure
---------

The :php:`user_settings` TCA column has the following structure:

:php:`columns`
    Array of field configurations, each containing:

    :php:`label`
        The field label (LLL reference or string)

    :php:`config`
        Standard TCA config array (type, renderType, items, etc.)

    :php:`table` (optional)
        Set to :php:`'be_users'` if the field is stored in a
        :sql:`be_users` table column

:php:`showitem`
    Comma-separated list of fields to display; supports
    :php:`--div--;` for tabs

Storing values in the database
==============================

If the user setting should persist in a real
:php:`be_users` database column, set:

:php:`'table' => 'be_users'`

The database field must exist and be configured via TCA as usual.

Available field types
=====================

User settings use standard TCA configuration.
Supported field types include:

* :code:`input`
* :code:`number`
* :code:`email`
* :code:`password`
* :code:`check` with :code:`renderType => checkboxToggle`
* :code:`select` with :code:`renderType => selectSingle`
* :code:`language`
