:navigation-title: Backend modules

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Backend module
..  _extbase-backend-module:

=====================================
Building backend modules with Extbase
=====================================

A backend module is where editors and administrators work with an extension's
own data: reviewing submissions, maintaining records that have no frontend
form, running reports over the domain model. Extbase is designed for this. The
domain models, repositories and validators an extension already has work in a
module unchanged, and the module's controllers are ordinary Extbase controllers
dispatched by the same code as a frontend plugin.

What changes is everything around the controller. A backend module does not
run inside a frontend request, so it reaches Extbase by a different route,
reads its configuration from a different place, and resolves its storage pages
and its language from the backend rather than from a plugin on a page. Knowing
these differences is what makes a module behave predictably.

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: :ref:`Registering an Extbase backend module <extbase-registration-backend-module>`

        The two Extbase-specific keys in :file:`Configuration/Backend/Modules.php`,
        access control, labels and rendering through the module template.

    ..  card:: :ref:`How an Extbase backend module works <extbase-backend-module-basics>`

        How a module request reaches the controller, which TypoScript a module
        sees, and how storage pages and language are resolved.

..  seealso::

    *   `Backend modules API <https://docs.typo3.org/permalink/t3coreapi:backend-modules-api>`_
        — the module registration reference, which applies to every module
        whether it uses Extbase or not.

    *   `Button components <https://docs.typo3.org/permalink/t3coreapi:button-components>`_
        — buttons and menus in the document header of a module. They are not
        Extbase-specific and work the same in an Extbase module.

..  toctree::
    :titlesonly:
    :hidden:

    HowModulesWork
    ConferencesModule
    ModerationModule
    EditingRecords
