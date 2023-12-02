..  include:: /Includes.rst.txt
..  index:: Hotkey API
..  _js-hotkey-api:

==========
Hotkey API
==========

..  versionadded:: 13.0

TYPO3 provides the :js:`@typo3/backend/hotkeys.js` module that allows developers
to register custom keyboard shortcuts in the TYPO3 backend.

It is also possible and highly recommended to register hotkeys in a dedicated
scope to avoid conflicts with other hotkeys, perhaps registered by other
extensions.

The module provides an enum with common modifier keys: :kbd:`Ctrl`, :kbd:`Meta`,
:kbd:`Alt`, and :kbd:`Shift`), and also a public property describing the common
hotkey modifier based on the user's operating system: :kbd:`Cmd` (Meta) on macOS,
:kbd:`Ctrl` on anything else. Using any modifier is optional, but highly
recommended.

A hotkey is registered with the :js:`register()` method. The method takes three
arguments:

:js:`hotkey`
    An array defining the keys that must be pressed.

:js:`handler`
    A callback that is executed when the hotkey is invoked.

:js:`options`
    An object that configures a hotkey's behavior:

    :js:`scope`
        The scope a hotkey is registered in.

        ..  note::
            TYPO3-specific hotkeys may be registered in the reserved :js:`all`
            scope. When invoking a hotkey from a different scope, the :js:`all`
            scope is handled in any case at first.

    :js:`allowOnEditables`
        If :js:`false` (default), handlers are not executed when an editable
        element is focussed.

    :js:`allowRepeat`
        If :js:`false` (default), handlers are not executed when the hotkey is
        pressed for a long time.

    :js:`bindElement`
        If given, an :html:`aria-keyshortcuts` attribute is added to the
        element. This is recommended for accessibility reasons.

..  seealso::
    :ref:`Keyboard commands in TYPO3 <t3editors:keyboard_commands>`


..  _js-hotkey-api-example:

Example
=======

..  literalinclude:: _example.js
    :language: js
    :caption: EXT:my_extension/Resources/Public/JavaScript/hotkey.js
