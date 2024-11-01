..  include:: /Includes.rst.txt

..  index::
    Bitsets; Usage
    Boolean flags

..  _BitSet:

=======
Bitsets
=======

Bitsets are used to handle boolean flags efficiently.

The class :php:`\TYPO3\CMS\Core\Type\BitSet` provides a TYPO3 implementation of
a bitset. It can be used standalone and accessed from the outside, but we
recommend creating specific bitset classes that extend the TYPO3
:php:`BitSet` class.

The functionality is best described by an example:

..  literalinclude:: _BitSet/_PlainExample.php
    :language: php

The example above uses global constants. Implementing that via an
extended bitset class makes it clearer and easier to use:

..  literalinclude:: _BitSet/_Permissions.php
    :language: php
    :caption: EXT:my_extension/Classes/Bitmask/Permissions.php

Then use your custom bitset class:

..  literalinclude:: _BitSet/_PlainExample2.php
    :language: php
