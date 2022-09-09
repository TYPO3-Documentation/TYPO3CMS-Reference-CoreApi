.. include:: /Includes.rst.txt

.. _custom-permissions:

===============================
Using Custom Permission Options
===============================

TYPO3 allows extension developers to register their own
permission options, managed automatically by the built-in user group
access lists. The options can be grouped in categories. A custom
permission option is always a checkbox (on/off).

The scope of such options is the backend only.

.. _custom-permissions-registration:

Registration
============

Options are configured in the global variable
:php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['customPermOptions']` in
:file:`EXT:my_extension/ext_tables.php`. The syntax is demonstrated in
the following example, which a custom permission option:

..  code-block:: php
    :caption: EXT:my_extension/ext_tables.php

    // Register some custom permission options shown in BE group access lists
    $GLOBALS['TYPO3_CONF_VARS']['BE']['customPermOptions']['tx_styleguide_custom'] = [
        'header' => 'Custom styleguide permissions',
            'items' => [
                'key1' => [
                    'Option 1',
                    // Icon has been registered above
                    'tcarecords-tx_styleguide_forms-default',
                    'Description 1',
                ],
            'key2' => [
                'Option 2',
            ],
        ],
    ];


The result is that these options appear in the group access lists like
this:

.. include:: /Images/AutomaticScreenshots/Examples/CustomPermissions/CustomOptions.rst.txt

As you can see it is possible to add both an icon and a description text.
If icons not provided by the Core are used, they need to be registered
with the :ref:`Icon API <icon>`.

.. _custom-permissions-evaluation:

Evaluation
==========

To check if a custom permission option is set call the following API
function from the user object:

.. code-block:: php
   :caption: EXT:some_extension/Classes/SomeClass.php

   $GLOBALS['BE_USER']->check('custom_options', $catKey . ':' . $itemKey);

:code:`$catKey` is the category in which the option resides. From the example
above this would be :code:`tx_examples_cat1`.

:code:`$itemKey` is the key of the item in the category you are evaluating.
From the example above this could be :code:`key1`, :code:`key2` or :code:`key3`
depending on which one of them you want to evaluate.

The function returns true if the option is set, otherwise false.


.. _custom-permissions-keys:

Keys for Options
================

It is good practice to use the extension keys prefixed with :code:`tx_` on
the first level of the array to avoid potential conflicts with other
custom options.

.. important::
   Never pick a key containing any of the characters
   ",:\\|". They are reserved delimiter characters.
