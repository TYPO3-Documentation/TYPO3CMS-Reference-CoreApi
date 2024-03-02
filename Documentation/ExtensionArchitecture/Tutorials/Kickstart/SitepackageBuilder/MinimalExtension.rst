.. include:: /Includes.rst.txt
.. index::
   Extension development; Minimal extension
   Tutorial; Minimal extension
.. _extension-minimal:

=================
Minimal extension
=================

Kickstart a minimal extension with the Sitepackage Builder
==========================================================

Learn how to create a minimal extension that contains a single PHP class.

.. contents::
   :local:

Video - "Tech Tip - Minimal Extension"
======================================

The following video was produced in 2018 on TYPO3 v9. While some details have
changed since then, most parts remain the same. See the step-by-step guide below.

.. youtube:: 15_HsnC_60Q

Minimal extension - step-by-step
================================

.. rst-class:: bignums

1.  Create a new sitepackage

    Head over to the `Site Package Builder <https://www.sitepackagebuilder.com/new/>`__.

    Choose your desired TYPO3 version and :guilabel:`Fluid Styled Content`
    as a base package.

    Fill in the other fields. Download the site package stub.

    You can find the code as it was produced at the time this tutorial was
    written for TYPO3 v11 at
    `speeddemo v1.0.0 <https://github.com/TYPO3-Documentation/speeddemo/releases/tag/1.0.0>`__.

2.  Install the extension locally

    See :ref:`Extension installation <extension-installation>`.

3.  Remove all the fluff

    The sitepackage builder creates many files that you don't need for this
    simple extension.

    You can delete the directories :file:`Build` and :file:`Configuration`.
    Delete all sub folders of :file:`Classes`. Delete all files and folders
    within :file:`Resources` except :file:`Resources/Public/Icons/Extension.svg`.

    Delete all files on root level except :file:`composer.json` and
    :file:`ext_emconf.php`. See what is left at
    `speeddemo v1.1.0 <https://github.com/TYPO3-Documentation/speeddemo/releases/tag/1.1.0>`__.

4.  The namespace and PSR-4 autoloading

    TYPO3 features :ref:`PSR-4 autoloading <autoload>`. If a PHP class is
    within the correct namespace and path it will be available automatically.

    Now what is the correct namespace for your extension? Look for the
    keyword "autoload" in the :file:`composer.json` of your extension. You
    will find something like this:

    ..  code-block:: json
        :caption: EXT:speeddemo/composer.json
        :emphasize-lines: 7

        {
            "name": "typo3-documentation-team/speeddemo",
            "type": "typo3-cms-extension",
            "...": "...",
            "autoload": {
                "psr-4": {
                    "Typo3DocumentationTeam\\Speeddemo\\": "Classes/"
                }
            },
        }

    The key in the array "psr-4" is your namespace:
    :php:`Typo3DocumentationTeam\Speeddemo`. Note: the backspace needs to be
    escaped by another backspace in json.

5.  Create a PHP class

    It is recommended, but not enforced, to put your class in a thematic
    subfolder. We will create a subfolder called :file:`Classes/UserFunctions`.

    In this folder we create a class in file :file:`MyClass.php`.

    The class in the file must have the same name as the file, otherwise it will be not
    found by autoloading. It must have a namespace that is a combination of the
    namespace defined in step 4 and its folder name(s). The complete class would
    look like this so far:

    ..  code-block:: php
        :caption: EXT:speeddemo/Classes/UserFunctions/MyClass.php
        :emphasize-lines: 5

        <?php

        declare(strict_types=1);

        namespace Typo3DocumentationTeam\Speeddemo\UserFunctions;

        class MyClass
        {

        }

    The extension now looks like
    `speeddemo v1.2.0 <https://github.com/TYPO3-Documentation/speeddemo/releases/tag/1.2.0>`__.

    .. note::
        It is recommended to always use strict types for new PHP classes. You
        can achieve this by adding the line :php:`declare(strict_types=1);` right
        after the opening PHP tag. The downside is in this case you have to
        make sure to always use correct types in PHP.

6.  Add a simple method to the class

    For demonstration reasons we add a simple method to the class that
    returns a string:

    ..  code-block:: php
        :caption: EXT:speeddemo/Classes/UserFunctions/MyClass.php
        :emphasize-lines: 5

        class MyClass
        {
            public function myMethod(): string
            {
                return 'Here I go again on my own';
            }
        }

    The extension now looks like
    `speeddemo v1.3.0 <https://github.com/TYPO3-Documentation/speeddemo/releases/tag/1.3.0>`__.

7.  Get the result of the function displayed

    Add some TypoScript to your sitepackage's TypoScript setup or the main
    TypoScript Template if you still keep your TypoScript in the backend
    (not recommended anymore).

    ..  code-block:: typoscript
        :caption: EXT:my_sitepackage/TypoScript/Setup/Page.typoscript

        page = PAGE
        // ...
        page.1 = USER
        page.1.userFunc = Typo3DocumentationTeam\Speeddemo\UserFunctions\MyClass->myMethod

    The string used in the property :typoscript:`userFunc` is the fully
    qualified name (FQN) of the class. That is the namespace followed by
    a backslash and then the classname. To this we append the name of the method
    to be called with a minus and greater-than sign (:typoscript:`->`).

    It is unnecessary to tell TYPO3 where the file of the class is located.
    If the namespace and location of the PHP file are correct as described above,
    the class will be found automatically.

    In rare cases composer autoloading might have a hiccup, then you can try to
    regenerate the autoloading files:

    ..  code-block:: bash
        :caption: Execute on your projects root level

        composer dump-autoload

Bonus: make the extension available for v12
===========================================

At the time of writing this tutorial, the sitepackage builder was not
available for TYPO3 v12 yet. However, as no deprecated functionality was
used in creating this extension, it should be straightforward to update.

You would use the same process if you need to update your extension for a
future TYPO3 version.

We can remove the requirements :json:`typo3/cms-rte-ckeditor` and
:json:`typo3/cms-fluid-styled-content` from the :file:`composer.json`
as they are not needed by our extension.

The remaining requirement is :json:`typo3/cms-core`. We now define that
not only TYPO3 v11.5.x is allowed but also v12.x:

..  code-block:: json
    :caption: EXT:speeddemo/composer.json
    :emphasize-lines: 6

    {
        "name": "typo3-documentation-team/speeddemo",
        "type": "typo3-cms-extension",
        "...": "...",
        "require": {
            "typo3/cms-core": "^11.5 || ^12.0"
        },
    }

Now we change the requirements in the file  :file:`ext_emconf.php`.
This way the extension could also be installed manually in legacy TYPO3
installations:

..  code-block:: php
    :caption: EXT:speeddemo/ext_emconf.php
    :emphasize-lines: 6

    $EM_CONF[$_EXTKEY] = [
        'title' => 'speeddemo',
        // ...
        'constraints' => [
            'depends' => [
                'typo3' => '11.5.0-12.4.99',
            ],
        ],
    ]

The extension now looks like
`speeddemo v1.4.0 <https://github.com/TYPO3-Documentation/speeddemo/releases/tag/1.4.0>`__
and can be installed in both TYPO3 v11 and v12.

Next steps
==========

You don't have a sitepackage yet? Have a look at the
:ref:`Sitepackage Tutorial <t3sitepackage:start>`.

If you want to display lists and single views of data, or maybe even manipulate
the data in the frontend, have a look at :ref:`Extbase <extbase>`.

If you need a script that can be executed from the command line or from a cron
job, have a look at :ref:`Symfony console commands (CLI) <symfony-console-commands>`.
