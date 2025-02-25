:navigation-title: Syntax

..  include:: /Includes.rst.txt
..  index:: YAML; Syntax
..  _yaml-syntax:

====================
YAML syntax in TYPO3
====================

Following is an introduction to the YAML syntax. If you are familiar with YAML, skip to
the **TYPO3 specific information**:

*   :ref:`yamlFileLoader`

..  seealso::

   A good general introduction to YAML syntax, basic data types, etc.:

   *    `"YAML Syntax" in Grav documentation <https://learn.getgrav.org/16/advanced/yaml>`__


The :ref:`TYPO3 coding guidelines for YAML <cgl-yaml>` define some basic rules to
be used in the TYPO3 Core  and extensions. Additionally, YAML has general syntax rules.

These are recommendations that should be followed for TYPO3. We pointed out where things
might break badly if not followed, by using MUST.

*   File ending ``.yaml``
*   Indenting with 2 spaces (not tabs). Spaces MUST be used. You MUST use the correct indenting level.
*   Use UTF-8
*   Enclose strings with single quotes (''). You MUST properly quote strings containing special
    characters (such as `@`) in YAML. In fact, generally using quotes for strings is encouraged.
    See `Symfony > The YAML Format > Strings <https://symfony.com/doc/current/components/yaml/yaml_format.html#strings>`__

..  attention::

    All text is case-sensitive.

To get a better understanding of YAML, you might want to compare YAML with PHP arrays:

..  code-block:: php
    :caption: An array in PHP

    $a = [
        'key1' => 'value',
        'key2' => [
            'key2_1' => 'value',
        ],
    ];

    $b = [
        'apples',
        'oranges',
        'bananas'
    ];


YAML:

..  code-block:: yaml
    :caption: The same array in YAML

    # mapping (key / value pairs)
    a:
      key1: 'value'
      key2:
        key2_1: 'value'

    # sequence (list)
    b:
      - 'apples'
      - 'oranges'
      - 'bananas'
