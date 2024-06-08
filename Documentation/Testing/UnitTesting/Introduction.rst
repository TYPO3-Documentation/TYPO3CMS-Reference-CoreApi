:navigation-title: Introduction

..  include:: /Includes.rst.txt
..  _testing-writing-unit-introduction:

============================
Introduction into unit tests
============================


This chapter goes into details about writing and maintaining unit tests in the TYPO3
world. Core developers over the years gained quite some knowledge and experience on
this topic, this section outlines some best practices and goes into details about
some of the TYPO3 specific unit testing details that have been put on top of the native
phpunit stack: At the time of this writing the TYPO3 Core contains about ten thousand
unit tests - many of them are good, some are bad and we're constantly improving
details. Unit testing is a great playground for interested contributors, and most
extension developers probably learn something useful from reading this section, too.

Note this chapter is not a full "How to write unit tests" documentation: It contains
some examples, but mostly goes into details of the additions `typo3/testing-framework <https://github.com/TYPO3/testing-framework>`_
puts on top.

Furthermore, this documentation is a general guide. There can be reasons to violate them.
These are no hard rules to always follow.


..  _testing-writing-unit-when:

When to unit test
=================

It depends on the code you're writing if unit testing that specific code is useful or not.
There are certain areas that scream to be unit tested: You're writing a method that does some PHP
array munging or sorting, juggling keys and values around? Unit test this! You're
writing something that involves date calculations? No way to get that right without unit
testing! You're throwing a regex at some string? The unit test data provider should already
exist before you start with implementing the method!

In general, whenever a rather small piece of code does some dedicated munging on a rather
small set of data, unit testing this isolated piece is helpful. It's a healthy developer
attitude to assume any written code is broken. Isolating that code and throwing unit tests at
it will proof its broken. Promised. Add edge cases to your unit test data provider, feed
it with whatever you can think of and continue doing that until your code survives all that.
Depending on your use case, develop `test-driven
<https://en.wikipedia.org/wiki/Test-driven_development>`_: Test first, fail, fix, refactor, next iteration.

Good to-be-unit-tested code does usually not contain much state, sometimes it's static.
:ref:`Services <cgl-services>` or :ref:`utilities <cgl-model-static-methods>` are often good
targets for unit testing, sometimes some detail method of a class that has not been extracted
to an own class, too.

..  _testing-writing-unit-when-not:

When not to unit test
=====================

Simply put: Do not unit test "glue code". There are persons proclaiming "100% unit test coverage".
This does not make sense. As an extension developer working on top of framework functionality, it
usually does not make sense to unit test glue code. What is glue code? Well, code
that fetches things from one underlying part and feeds it to some other part: Code that "glues"
framework functionality together.

Good examples are often Extbase MVC controller actions: A typical controller usually does not do much
more than fetching some objects from a repository just to assign them to the view. There is no benefit in
adding a unit test for this: A unit test can't do much more than verifying some specific framework
methods are actually called. It thus needs to mock the object dependencies to only verify some
method is hit with some argument. This is tiresome to set up and you're then testing a trivial
part of your controller: Looking at the controller clearly shows the underlying method *is* called.
Why bother?

Another example are Extbase models: Most Extbase model properties consist of a protected property,
a getter and a setter method. This is near no-brainer code, and many developers auto-generate
getters and setters by an IDE anyway. Unit testing this code leads to broken tests with each trivial
change of the model class. That's tiresome and likely some waste of time. Concentrate unit testing
efforts on stuff that does data munging magic as outlined above! One of your model getters initializes
some object storage, then sorts and filters objects? *That* can be helpful if unit tested, your filter
code is otherwise most likely broken. Add unit tests to prove it's not.

A much better way of testing glue code are functional tests: Set up a proper scenario in your
database, then call your controller that will use your repository and models, then verify your
view returns something useful. With adding a functional test for this you can kill many
birds with one stone. This has many more benefits than trying to unit test glue code.

A good sign that your unit test would be more useful if it is turned into a functional test is if
the unit tests needs lots of lines of code to mock dependencies, just to test something using
:php:`->shouldBeCalled()` on some mock to verify on some dependency is actually called. Go ahead and
read some unit tests provided by the Core: We're sure you'll find a bad unit test that could be improved
by creating a functional test from it.

..  _testing-writing-unit-simple:

Keep it simple
==============

This is an important rule in testing: Keep tests as simple as possible! Tests should be easy
to write, understand, read and refactor. There is no point in complex and overly abstracted
tests. Those are pain to work with. The basic guides are: No loops, no additional class
inheritance, no additional helper methods if not really needed, no additional state. As simple
example, there is often no point in creating an instance of the subject in :php:`setUp()` just to
park it as in property. It is easier to read to just have a :php:`$subject = new MyClass()`
call in each test at the appropriate place. Test classes are often much longer than the
system under test. That is ok. It's better if a single test is very simple and to copy over
lines from one to the other test over and over again than trying to abstract that away.
Keep tests as simple as possible to read and don't use fancy abstraction features.
