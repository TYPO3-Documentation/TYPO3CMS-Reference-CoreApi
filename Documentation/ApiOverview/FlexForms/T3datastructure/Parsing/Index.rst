:navigation-title: Parsing

..  include:: /Includes.rst.txt
..  _t3ds-parsing:

===========================
Parsing T3DataStructure XML
===========================

You can convert a Data Structure XML document into a PHP array by using the
function :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::xml2array()`.

The reverse transformation is achieved using
:php:`\TYPO3\CMS\Core\Utility\GeneralUtility::array2xml()`.

The PHP array can then be interpreted by the application, which may interpret
the T3DataStructure in custom ways.

`Sheet References <https://docs.typo3.org/permalink/t3coreapi:t3ds-sheet-references>`_
are not supported out of the box and have to be resolved by the application using
the T3DataStructure.

..  seealso::
    `Reading FlexForm settings <https://docs.typo3.org/permalink/t3coreapi:read-flexforms>`_
