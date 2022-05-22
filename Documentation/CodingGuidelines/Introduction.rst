.. include:: /Includes.rst.txt
.. _cgl-introduction:

============
Introduction
============

This chapter defines coding guidelines for the TYPO3 CMS project.
Following these guidelines is mandatory for TYPO3 Core  developers and
contributors to the TYPO3 Core .

Extension authors are encouraged to follow these guidelines
when developing extensions for TYPO3. Following these guidelines makes
it easier to read the code, analyze it for learning or performing code
reviews. These guidelines also help preventing typical errors in the
TYPO3 code.

This chapter defines how TYPO3 code, files and directories should be
outlined and formatted. It gives some thoughts on general coding
flavors the Core tries to follow.

.. index:: Coding guidelines; Quality assurance
.. _cgl-quality-assurance:

The CGL as a Means of Quality Assurance
=======================================

Our programmers know the CGL and are encouraged to inform authors,
should their code not comply with the guidelines.

Apart from that, adhering to the CGL is not voluntary: The CGL are also
enforced by structural means: Automated tests are run by the continuous
integration tool `bamboo` to make sure that every (core) code change complies
with the CGL. In case a change does not meet the criteria, bamboo will
give a negative vote in the review system and point to the according
problem.

Following the coding guidelines not necessarily means more work for
Core contributors: The automatic CGL check performed by bamboo can
be easily replayed locally: If the test setup votes negative on a
Core patch in the review system due to CGL violations, the patch
can be easily fixed locally by calling :file:`./Build/Scripts/cglFixMyCommit.sh`
and pushed another time. For details on Core contributions, have a look at the
:doc:`TYPO3 Contribution Guide <t3contribute:Index>`.


.. _cgl-general-recommendations:

General Recommendations
=======================

.. index::
   pair: Coding guidelines; Editor
   pair: Coding guidelines; IDE

.. _cgl-ide:

Setup IDE / Editor
------------------

.. important::

   You are strongly advised to set up your editor / IDE properly so that the
   standards get checked and enforced automatically!


.. index:: pair: Coding guidelines; EditorConfig
.. _cgl-editorconfig:

EditorConfig
~~~~~~~~~~~~

One method to set up your IDE / editor to adhere to specific Coding Guidelines,
is to use an .editorconfig file. Read `EditorConfig.org <https://EditorConfig.org>`__
to find out more about it. Various IDEs or Editors support editorconfig by default or with
an additional plugin.

For example, for PhpStorm there is an `EditorConfig plugin <https://plugins.jetbrains.com/plugin/7294-editorconfig>`__.

An `.editorconfig <https://github.com/typo3/typo3/blob/main/.editorconfig>`__
file is included in the TYPO3 source code.
