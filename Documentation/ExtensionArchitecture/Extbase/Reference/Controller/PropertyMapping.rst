:navigation-title: Property mapping

..  include:: /Includes.rst.txt
..  index:: Extbase; PropertyMapper
..  _extbase-property-mapping:

=======================
Extbase property mapper
=======================

Extbase provides a property mapper to convert different values, like integers
or arrays, to other types, like strings or objects.

In this example, we provide a string that will be converted to an integer:

..  include:: /CodeSnippets/Extbase/PropertyManager/IntegerMapping.rst.txt

Conversion is done by using the :php:`TYPO3\CMS\Extbase\Property\PropertyMapper::convert()`
method.

..  note::
    The :php:`PropertyMapper` has to be injected before it can be used:

    ..  include:: /CodeSnippets/Extbase/PropertyManager/PropertyMapperInjection.rst.txt

..  _extbase-property-mapping-how-to:

How to use property mappers
===========================

This example shows a simple conversion of a string into a model:

..  include:: /CodeSnippets/Extbase/PropertyManager/ObjectMapping.rst.txt

The result is a new instance of :php:`FriendsOfTYPO3\BlogExample\Domain\Model\Tag`
with defined property `name`.

..  note::
    The property mapper will not check the validation rules. The result will be
    whatever the input is.
