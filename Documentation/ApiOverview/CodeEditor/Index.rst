..  include:: /Includes.rst.txt
..  index:: Code editor
..  _code-editor:

===========
Code editor
===========

..  versionchanged:: 13.0
    The code editor functionality was moved from the optional "t3editor" system
    extension into the "backend" system extension. The code editor is therefore
    always available.

    Checks whether the previous system extension is installed via
    :php:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('t3editor')`
    are now obsolete.

The code editor provides a backend editor with syntax highlighting. The editor
is used by TYPO3 itself for :ref:`TCA fields with type "text" and renderType
"codeEditor" <t3tca:columns-text-renderType-codeEditor>` and in the module
:guilabel:`Media > Filelist`. Under the hood, `CodeMirror`_ is used.

..  contents::
    :local:


Usage in TCA
============

Extensions may configure backend fields to use the code editor by TCA. The
editor is only available for fields of type :ref:`text <t3tca:columns-text>`. By
setting the :php:`renderType` to :php:`codeEditor` the syntax highlighting can
be activated.

By setting the property :ref:`format <t3tca:columns-text-properties-format>`
the mode for syntax highlighting can be chosen. Allowed values:

*   :php:`css`
*   :php:`html`
*   :php:`javascript`
*   :php:`json`
*   :php:`php`
*   :php:`sql`
*   :php:`typoscript`
*   :php:`xml`
*   and any :ref:`custom mode <code-editor-register-mode>` registered by an
    extension.

Example
-------

..  code-block:: php
    :caption: Excerpt of TCA definition (EXT:my_extension/Configuration/TCA/tx_myextension_domain_model_mytable.php)

    [
        'columns' => [
            'codeeditor1' => [
                'label' => 'codeEditor_1 format=html, rows=7',
                'description' => 'field description',
                'config' => [
                    'type' => 'text',
                    'renderType' => 'codeEditor',
                    'format' => 'html',
                    'rows' => 7,
                ],
            ],
        ],
    ]

Displays an editor like the following:

..  figure:: /Images/ManualScreenshots/CodeEditor/CodeEditor.png
    :alt: A code editor with syntax highlighting for HTML
    :class: with-shadow

    A code editor with syntax highlighting for HTML


..  _code-editor-extend:

Extend the code editor
======================

Custom modes (used for syntax highlighting) and addons can be registered.

`CodeMirror`_ delivers a lot more modes and addons than registered in the code
editor by default.

More supported addons and modes are available at:

*   https://github.com/codemirror/codemirror5/tree/5.27.4/addon
*   https://github.com/codemirror/codemirror5/tree/5.27.4/mode

To register custom addons and modes, extensions may have these two files to
extend the code editor:

*   :file:`Configuration/Backend/T3editor/Addons.php`
*   :file:`Configuration/Backend/T3editor/Modes.php`

Both files return an array, as known as in :ref:`TCA <t3tca:start>` and
:ref:`backend routes <extension-configuration-backend-routes>`, for example.


..  _code-editor-register-addon:

Register an addon
-----------------

To register an addon, the following code may be used:

..  literalinclude:: _register_addon.php
    :language: php
    :caption: EXT:my_extension/Configuration/Backend/T3editor/Addons.php

The following configuration options are available:

..  confval:: <identifier>
    :name: code-editor-register-addon-identifier
    :type: string
    :Required: true

    Represents the unique identifier of the module (:php:`my/addon` in this
    example).

..  confval:: module
    :name: code-editor-register-addon-module
    :type: string
    :Required: true

    Holds the JavaScriptModuleInstruction of the CodeMirror module.

..  confval:: cssFiles
    :name: code-editor-register-addon-cssFiles
    :type: array

    Holds all CSS files that must be loaded for the module.

..  confval:: options
    :name: code-editor-register-addon-options
    :type: array

    Options that are used by the addon.

..  confval:: modes
    :name: code-editor-register-addon-modes
    :type: array

    If set, the addon is only loaded if any of the modes supplied here is used.


..  _code-editor-register-mode:

Register a mode
---------------

To register a mode, the following code may be used:

..  literalinclude:: _register_mode.php
    :language: php
    :caption: EXT:my_extension/Configuration/Backend/T3editor/Modes.php

The following configuration options are available:

..  confval:: <identifier>
    :name: code-editor-register-mode-identifier
    :type: string
    :Required: true

    Represents the unique identifier and format code of the mode
    (`css` in this example). The format code is used in TCA to
    define the CodeMirror mode to be used.

    Example:

    ..  code-block:: php

        $GLOBALS['TCA']['tt_content']['types']['css']['columnsOverrides']['bodytext']['config']['format'] = 'css';

..  confval:: module
    :name: code-editor-register-mode-module
    :type: string
    :Required: true

    Holds the JavaScriptModuleInstruction of the CodeMirror module.

..  confval:: extensions
    :name: code-editor-register-mode-extensions
    :type: array

    Binds the mode to specific file extensions. This is important for using
    the code editor in the module :guilabel:`Media > Filelist`.

..  confval:: default
    :name: code-editor-register-mode-default
    :type: bool

    If set, the mode is used as fallback if no sufficient mode is available.
    By factory default, the default mode is `html`.


..  _CodeMirror: https://github.com/codemirror/codemirror5
