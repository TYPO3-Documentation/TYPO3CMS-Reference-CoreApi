..  include:: /Includes.rst.txt
..  index:: Site handling; Settings

..  _site-settings-definition:

=========================
Site settings definitions
=========================

..  versionadded:: 13.1

The big problem with TypoScript and TSConfig is that each specified value can
only ever be a string. It is up to the developer alone to read these values
and convert them into the desired data type such as integer.

TYPO3 wants to remedy this with settings definitions and now provides an API
with which you can add additional descriptive definitions for each individual
site setting.

..  literalinclude:: _Settings/_settings.definitions.yaml
    :caption: EXT:my_extension/Configuration/Sets/MySet/settings.definitions.yaml

..  _definition-types:

Definition types
================

..  confval:: int
    :name: site-setting-type-int
    :type: string
    :Path: settings.[my_val].type = int

    Checks whether the value is already an integer or can be interpreted as an
    integer. If yes, the string is converted into an integer.

..  confval:: number
    :name: site-setting-type-number
    :type: string
    :Path: settings.[my_val].type = number

    Checks whether the value is already an integer or float or whether the
    string can be interpreted as an integer or float. If yes, the string is
    converted to an integer or float.

..  confval:: bool
    :name: site-setting-type-bool
    :type: string
    :Path: settings.[my_val].type = bool

    If the value is already a boolean, it is returned directly 1 to 1.

    If the value is an integer, then `false` is returned for 0 and `true` for 1.

    If the value is a string, the corresponding Boolean value is returned for
    `true`, `false`, `yes`, `no`, `on`, `off`, `0` and `1`.

..  confval:: string
    :name: site-setting-type-string
    :type: string
    :Path: settings.[my_val].type = string

    Converts almost all data types into a string. If an object has been
    specified, it must be `stringable`, otherwise no conversion takes place.
    Boolean values are converted to `true` and `false`.

..  confval:: text
    :name: site-setting-type-text
    :type: string
    :Path: settings.[my_val].type = text

    Exactly the same as the `string` type. Use it as an alias if someone doesn't
    know what to do with `string`.

..  confval:: stringlist
    :name: site-setting-type-stringlist
    :type: string
    :Path: settings.[my_val].type = stringlist

    The value must be an array whose array keys start at 0 and increase by 1 per
    element. The list in this type is derived from the internal PHP method
    `array_is_list` and has nothing to do with the fact that comma-separated
    lists can also be converted here.

    The `string` type is executed for each array entry.

..  confval:: color
    :name: site-setting-type-color
    :type: string
    :Path: settings.[my_val].type = color

    Checks whether the specified string can be interpreted as a color code.
    Entries starting with `rgb`, `rgba` and `#` are permitted here.

    For `#` color codes, for example, the system checks whether they
    have 3, 6 or 8 digits.
