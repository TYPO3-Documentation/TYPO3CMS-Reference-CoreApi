..  include:: /Includes.rst.txt

..  index::
    Extbase; Tea
    Tutorial; Tea
    Tutorial Tea
..  _extbase_tutorial_tea:

=================
Tea in a nutshell
=================

The example extension :t3ext:`tea` was created as an example of best practises
on automatic code checks.

..  hint::
    If you want to learn more about automatic code checks
    see the :doc:`documentation of tea <ext_tea:Index>` and the chapter on
    :ref:`Testing <testing>` in this manual.

In this manual, however we will ignore the testing and just explain how this
 example extension works. The extension demonstrates basic functionality and is very well tested

..  attention::
    The example extension tea should not be used as a kickstarter or
    template for your own extension. It is an example to be
    studied and copied from.

Steps in this tutorial:

..  rst-class:: bignums-xxl

#.  :ref:`Extension configuration and installation <extbase_tutorial_tea_extension_configuration>`

    Create the files needed to have a minimal running extension and install it.

#.  :ref:`Directory structure <extbase_tutorial_tea_extension_configuration>`

    Have a look at the directory structure of the example extension and learn
    which files should go where.

..  note::
    This tutorial is work in progress. As we want to prevent epic pull requests,
    we will create it step by step. Stay tuned.

..  toctree::
    :titlesonly:

    ExtensionConfiguration
    DirectoryStructure
    Model
