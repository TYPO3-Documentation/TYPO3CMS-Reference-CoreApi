.. include:: ../../Includes.txt

.. _yaml-syntax:

=============
YAML syntax
=============

Following is an introduction to the YAML syntax. If you are familiar with YAML, skip to
the **TYPO3 specific information**:

* :ref:`yamlFileLoader`

.. seealso::

   A good general introduction to YAML syntax, basic data types, etc.:

   * `"YAML Syntax" in Grav documentation <https://learn.getgrav.org/16/advanced/yaml>`__


The :ref:`TYPO3 coding guidelines for YAML <cgl-yaml>` define some basic rules to
be used in the TYPO3 core and extensions. Additionally, yaml has general syntax rules.

* File ending ``.yaml``
* Indenting with 2 spaces (not tabs). Spaces MUST be used. You MUST use the correct indenting level.
* Use UTF-8
* All text is case-sensitive
* Enclose strings with single quotes ('')

.. important::

   The following MUST be adhered to in order to produce valid syntax:

   #. Use spaces, not tabs to indent
   #. Identing is not optional. It is used to define the hierarchy of the data


To get a better understanding of YAML, you might want to compare YAML with PHP arrays:

PHP::

    $a = [
        'key1' => 'value',
        'key2' => [
            'key2_1' => 'value'
    ];

    $b = [
        'apples',
        'oranges',
        'bananas'
    ];


YAML:

.. code-block:: yaml

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

