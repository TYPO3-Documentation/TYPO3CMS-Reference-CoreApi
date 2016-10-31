.. include:: ../../../Includes.txt


.. _custom-permissions:

Using custom permission options
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

TYPO3 allows extension developers to register their own
permission options, managed automatically by the built-in user group
access lists. The options can be grouped in categories. A custom
permission option is always a checkbox (on/off).

The scope of such options is the backend only.


.. _custom-permissions-registration:

Registration
""""""""""""

Options are configured in the global variable :code:`$TYPO3_CONF_VARS['BE']['customPermOptions']` in
:file:`ext_tables.php`. The syntax is demonstrated in the following example, which adds three options
under a given header:

.. code-block:: php

   $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
   $iconRegistry->registerIcon(
      'styleguide-icon-svg',
      \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
      [ 'source' => 'EXT:styleguide/Resources/Public/Icons/provider_svg_icon.svg',]
    );

   $GLOBALS['TYPO3_CONF_VARS']['BE']['customPermOptions'] = array(
      'tx_examples_cat1' => array(
         'header' => 'LLL:EXT:examples/Resources/Private/Language/locallang.xlf:permissions_header',
         'items' => array(
            'key1' => array(
               'LLL:EXT:examples/Resources/Private/Language/locallang.xlf:permissions_option1',
               'styleguide-icon-svg',
               'LLL:EXT:examples/Resources/Private/Language/locallang.xlf:permissions_option1_description',
            ),
            'key2' => array('LLL:EXT:examples/Resources/Private/Language/locallang.xlf:permissions_option2'),
            'key3' => array('LLL:EXT:examples/Resources/Private/Language/locallang.xlf:permissions_option3'),
         )
      )
   );


The result is that these options appear in the group access lists like
this:

.. figure:: ../../../Images/CustomOptions.png
   :alt: Custom permissions

   The custom permissions appear in the Access List tab of backend user groups


As you can see it is possible to add both an icon and a description text, that will
be displayed as context-sensitive help. If icons not provided by the core are used,
they need to be registered with the icon API.


.. _custom-permissions-evaluation:

Evaluation
""""""""""

To check if a custom permission option is set simply call the API
function from the user object::

   $BE_USER->check('custom_options', $catKey . ':' . $itemKey);

:code:`$catKey` is the category in which the option resides. From the example
above this would be :code:`tx_examples_cat1`.

:code:`$itemKey` is the key of the item in the category you are evaluating.
From the example above this could be :code:`key1`, :code:`key2` or :code:`key3`
depending on which one of them you want to evaluate.

The function returns true if the option is set, otherwise false.


.. _custom-permissions-keys:

Keys for options
""""""""""""""""

It is good practice to use the extension keys prefixed with :code:`tx_` on
the first level of the array to avoid potential conflicts with other
custom options.

.. important::
   Never pick a key containing any of the characters
   ",:\\|". They are reserved delimiter characters.
