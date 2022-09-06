..  include:: /Includes.rst.txt

..  index::
    Tutorial Tea; Model
..  _extbase_tutorial_tea_model:

===================
Model: a bag of tea
===================

We keep the model basic: Each tea can have a title, a description, and an optional image.

..  uml::

    class Tea {
        title
        ==
        description
        ==
        image
    }

The title and description are strings, the image is stored as a relation
to the model class :php:`\TYPO3\CMS\Extbase\Domain\Model\FileReference`, provided
by Extbase.


..  _extbase_tutorial_tea_model_database:

The database model
==================

Let us translate this into SQL and store the schema in a file called
:file:`ext_tables.sql`:

..  include:: /CodeSnippets/Tutorials/Tea/ExtTablesSql.rst.txt

The image is stored as an integer. However the field :sql:`image` in the
database does not contains a reference to the image in form of an identifier.

The field :sql:`image` keeps track of the number of attached images. A separate table,
a so-called MM table, stores the actual relationship. Read about the definition
of this field here: :ref:`extbase_tutorial_tea_model_columns_image`.

..  hint::
    If you have had a look at a TYPO3 database before, you might wonder:
    What about all those special fields like :sql:`uid`, :sql:`pid`,
    :sql:`deleted`, etc? The answer is that TYPO3 will generate them automatically
    for you.

..  _extbase_tutorial_tea_model_tca:

TCA - Table Configuration Array
===============================

The TCA tells TYPO3 about the database model. It defines all fields
containing data and all semantic fields that have a special meaning within
TYPO3 (like the :sql:`deleted` field used, for soft deleting).

The TCA also defines how the corresponding input fields in the backend should look.

The TCA is a nested PHP array. In this example, we need the the following
keys on the first level:

:php:`ctrl`
    Settings for the complete table, such as a record title, a label
    for a single record, default sorting, and the names of some
    internal fields.

:php:`types`
    We only have one type of tea record, however it is mandatory to
    describe at least one type. Here we define the order in which
    the fields are displayed in the backend.

:php:`columns`
    Here we define all fields that can be used for user input in the
    backend.


..  _extbase_tutorial_tea_model_ctrl:

TCA :php:`ctrl` - Settings for the complete table
-------------------------------------------------

..  include:: /CodeSnippets/Tutorials/Tea/Configuration/TCA/TeaCtrl.rst.txt

..  _extbase_tutorial_tea_model_ctrl_title:

:php:`title`
~~~~~~~~~~~~

Defines the title used when we are talking about the table in the backend.
It will be displayed on top of the list view of records in the backend
and in backend forms.

..  figure:: /Images/ManualScreenshots/ExtensionArchitecture/Tutorials/Tea/TeaTitle.png
    :class: with-shadow

    The **title** of the :sql:`tea` table.

Strings starting with :php:`LLL:` will be localized. See chapter
:ref:`Extension localization <extension_localization>`. All other strings
would be output as strings. You could also write:

.. code-block:: php
   :caption: EXT:tea/Configuration/TCA/tx_tea_domain_model_product_tea.php

   [
       'ctrl' => [
           'title' => 'Tea',
       ],
   ]

..  _extbase_tutorial_tea_model_ctrl_label:

:php:`label`
~~~~~~~~~~~~

The :php:`label` is used as name for a specific tea record. The name is used
in listings, dropdown fields used to reference a tea record and in the forms
for editing records in the backend:


..  figure:: /Images/ManualScreenshots/ExtensionArchitecture/Tutorials/Tea/TeaLabel.png
    :class: with-shadow

    The **label** of a tea record. Yeah, sorry, Coffee is my tea...

..  _extbase_tutorial_tea_model_ctrl_others:

:php:`tstamp`, :php:`deleted`, ...
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

These fields are used for different aspects of handling tables. You can read in
depth in the `TCA Reference, chapter ctrl <t3tca:ctrl>` about what they mean and
are used for.

..  _extbase_tutorial_tea_model_columns:

TCA :php:`columns` - Defining the database fields
-------------------------------------------------

All fields that can be changed in the TYPO3 backend or used in the Extbase
model have to be listed here. Otherwise they will not be recognized by
any API call to the table.

The title input field is defined like that:

..  include:: /CodeSnippets/Tutorials/Tea/Configuration/TCA/TeaColumnTitle.rst.txt

The title of the field is displayed above the input field. The type is a (string)
input field. The other configuration values influence display (size of the input
field) and or processing on saving (:php:`'eval' => 'trim' removes whitespace).

You can find a complete list of available input types and their propererties in
the :`TCA Reference, chapter "Field types (config > type)" <t3tca:columns-types>`.

The other text fields are defined in a similar matter.

..  _extbase_tutorial_tea_model_columns_image:

The :php:`image` field
~~~~~~~~~~~~~~~~~~~~~~

The image field is a special case as it is created by a call to the API function
:php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig()`.
This method returns a readily configured array in accordance to what the current
TYPO3 version needs. It also saves you from writing a long and complicated array.

..  code-block:: php
    :caption: EXT:tea/Configuration/TCA/tx_tea_domain_model_product_tea.php

    [
        'columns' => [
            'image' => [
                'label' => 'LLL:EXT:tea/Resources/Private/Language/locallang_db.xlf:tx_tea_domain_model_product_tea.image',
                'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                    'image',
                    [
                        'maxitems' => 1,
                        'appearance' => [
                            'collapseAll' => true,
                            'useSortable' => false,
                            'enabledControls' => [
                                'hide' => false,
                            ],
                        ],
                    ]
                ),
            ],
        ],
    ];

..  tip::
    Do not worry about performance caused by the API call, the TCA files are
    cached in compiled form.

The array generated by the method
:php:`ExtensionManagementUtility::getFileFieldTCAConfig()` looks like that:

..  include:: /CodeSnippets/Tutorials/Tea/Configuration/TCA/TeaColumnImage.rst.txt

Now are you happy this was brewed for you and you did not have to type it
yourself?

..  _extbase_tutorial_tea_model_types:

TCA :php:`types` - Configure the input form
-------------------------------------------

..  include:: /CodeSnippets/Tutorials/Tea/Configuration/TCA/TeaTypes.rst.txt

The key :php:`showitem` lists all fields that should be displayed in the
backend input form in the order they should be displayed.

..  hint::
    It is possible to influence the display of the fields in more sophisticated
    ways: You can order them in tabs, put them into palettes etc. See
    :ref:`TCA reference, showitem <t3tca:types-properties-showitem>` for
    details.

Result - the complete TCA
--------------------------

Have a look at the complete file
`EXT:tea/Configuration/TCA/tx_tea_domain_model_product_tea.php <https://github.com/TYPO3-Documentation/tea/blob/main/Configuration/TCA/tx_tea_domain_model_product_tea.php>`__.

The edit form for tea records in the backend now looks like this:

..  figure:: /Images/ManualScreenshots/ExtensionArchitecture/Tutorials/Tea/TeaEditForm.png
    :class: with-shadow

    The complete input form for a tea record

The list of teas in the module :guilabel:`Web -> List` looks like this:


..  figure:: /Images/ManualScreenshots/ExtensionArchitecture/Tutorials/Tea/TeaList.png
    :class: with-shadow

    A list of teas in the backend

..  note::
    Up to this point we have only used TYPO3 Core features. You can create
    tables and backend forms exactly the same way without using Extbase.

The Extbase model
=================

It is a common practice - though not mandatory - to use PHP class to store the
data while working on it.

The model is an additional abstraction from the database. It enables the
developer to require variable types beyond what the database abstraction layer
offers. The model can also be used to apply validators to the properties
of the model and to specify relationship types (should relatives be loaded
lazily? Should they be deleted if this object is deleted?).

Extbase models extend the class
:php:`TYPO3\CMS\Extbase\DomainObject\AbstractEntity` provided by Extbase.
The parent classes of this class already offer methods needed for persistence in
to database, accessing the identifier :php:`uid` etc.

.. include:: /CodeSnippets/Tutorials/Tea/Classes/Domain/Model/TeaProperties.rst.txt

..  attention::
    All properties of the model have to have the modifier :php:`protected` or
    :php:`public`. :php:`private` properties are not supported as properties have to
    be accessed by the repository and persistence and layers internally.

    If you want to prevent developers from extending you model, and though
    accessing the properties of you model, you can make the class of the model
    final.

For all :php:`protected` properties we need at least a getter of the according
name. If the property should be writable within the Extbase workflows it also
has to have a getter. Properties that are only set in the backend forms do not
need a setter.

Example for the property :php:`title`:

..  include:: /CodeSnippets/Tutorials/Tea/Classes/Domain/Model/TeaTitle.rst.txt

The getter for the image also has to resolve the lazy loading:

..  include:: /CodeSnippets/Tutorials/Tea/Classes/Domain/Model/TeaImage.rst.txt

See the complete
`class on Github: Tea <https://github.com/TYPO3-Documentation/tea/blob/main/Classes/Domain/Model/Product/Tea.php>`__.

Next steps
==========

.. TODO: Link this as soon as written

*   The repository - Query for tea
