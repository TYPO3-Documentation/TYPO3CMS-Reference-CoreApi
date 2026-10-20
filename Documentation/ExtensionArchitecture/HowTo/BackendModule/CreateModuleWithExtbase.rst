:navigation-title: Extbase controller

..  include:: /Includes.rst.txt

..  _backend-modules-extbase:
..  _backend-modules-template:

====================================
Create a backend module with Extbase
====================================

..  tip::

    A module that mainly shows and changes a few records does not need Extbase.
    See :ref:`Create a backend module with Core functionality
    <backend-modules-template-without-extbase>`.

A backend module can be built with Extbase and Fluid. The module's controller
is an Extbase :php-short:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController`,
and the domain models, repositories and validators of the extension work in
the module as they do in a frontend plugin. This is the better choice when the
module works with a domain model of its own.

An Extbase controller needs no attribute. Every class implementing
:php-short:`\TYPO3\CMS\Extbase\Mvc\Controller\ControllerInterface` is tagged
and made public automatically. The
:php-short:`\TYPO3\CMS\Backend\Attribute\AsController` attribute is only for
:ref:`backend controllers without Extbase
<backend-modules-template-without-extbase>`.

..  versionchanged:: 14.0
    :changelog: breaking-105377-1729513863

    The class alias for :php:`\TYPO3\CMS\Backend\Attribute\Controller` has been
    removed. :php:`\TYPO3\CMS\Backend\Attribute\AsController` is still in place.

Building such a module is described in a dedicated chapter:

*   :ref:`Registering an Extbase backend module
    <extbase-registration-backend-module>` — the Extbase-specific keys in
    :file:`Configuration/Backend/Modules.php`, and rendering with
    :php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplate` instead of
    :php:`$this->view`.
*   :ref:`How an Extbase backend module works <extbase-backend-module-basics>`
    — how a request reaches the controller, which TypoScript the module sees,
    and how storage pages and language are resolved.
*   :ref:`Building an Extbase backend module without a page tree
    <extbase-backend-module-no-page-tree>` — a list with search, filters and
    pagination, and filters kept across requests.
*   :ref:`Editing records from an Extbase backend module
    <extbase-backend-module-editing>` — creating, editing and deleting records
    through FormEngine and DataHandler instead of own actions.
*   :ref:`Building an Extbase backend module with a page tree
    <extbase-backend-module-page-tree>` — a module that takes its storage
    folder, site and language from the selected page.


..  _backend-modules-extbase-template:

Fluid templates of an Extbase backend module
============================================

A module template uses the `Module` layout and puts its content into the
`Content` section. The layout belongs to the backend, not to the extension.

:php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplate` looks for templates
and layouts in :path:`EXT:backend/Resources/Private/` first, and in the
extension that registered the module second. That is why
:html:`<f:layout name="Module" />` finds the backend's
:file:`Layouts/Module.fluid.html` without any configuration.
:php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplate` also supplies the
document header and flash messages the layout renders:

..  literalinclude:: /ExtensionArchitecture/Extbase/BackendModule/_snippets/_ConferenceList.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/ConferenceModule/List.fluid.html
    :visible-lines: 1-12,84-86

..  warning::

    Do not add a :file:`Layouts/Module.fluid.html` to your extension unless
    you mean to replace the backend's layout. The extension's paths are
    searched after the backend's, so its file wins, and a copied layout no
    longer follows changes in Core. To change templates of a module
    deliberately, use the :ref:`templates <t3tsref:pagetemplates>` option of
    page TSconfig.

The same layout serves modules without Extbase. Buttons, menus and the
breadcrumb in the document header are not Extbase-specific either, see
:ref:`Button components <button-components>` and :ref:`DocHeaderComponent
<docheadercomponent>`.

The best way to learn more is to read the modules that ship with TYPO3. The
backend user module (:composer:`typo3/cms-beuser`) and the log module
(:composer:`typo3/cms-belog`) are built with Extbase.
