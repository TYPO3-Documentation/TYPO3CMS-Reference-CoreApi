.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


Localization
^^^^^^^^^^^^

TYPO3 is designed to be fully localizable. Hard-coded strings should
thus be avoided unless there are some technical limitations (e.g. some
early or low-level stuff where a :code:`lang` object is not yet
available).


Defining localized strings
""""""""""""""""""""""""""

Here are some rules to respect when working with labels in :code:`locallang`
files:

- always check the existing locallang files to see if a given localized
  string already exists, in particular :code:`EXT:lang/locallang\_common.xml`
  and :code:`EXT:lang/locallang\_core.xml`.

- localized strings should never be all uppercase. If uppercase is needed,
  then appropriate methods should be used to transform them to uppercase.

- localized strings must not be split into several parts to include
  stuff in their middle. Rather use a single string with
  :code:`sprintf()` markers (:code:`%s`, :code:`%d`, etc.).

- when a localized string contains several :code:`sprintf()` markers, it
  **must** use numbered arguments (e.g. :code:`%1$d`).

- punctuation marks **must** be included in the localized string –
  including trailing marks – as different punctuation marks (e.g. "?"
  and "¿") may be used in various languages. Also some languages include
  blanks before some punctuation marks.

- localized strings are not supposed to contain HTML tags, except for
  CSH. They should be avoided whenever possible.

Once a localized string appears in a released version of TYPO3, it
cannot be changed (unless it needs grammar or spelling fixes). Nor can
it be removed. If the label of a localized string has to be changed, a
new one should be introduced instead.


Using localized strings
"""""""""""""""""""""""

Localized string are displayed using the available API: mostly
:code:`lang::getLL()` when the corresponding locallang file is loaded,
:code:`lang::sL()` otherwise. In both these methods, the second call
parameter should be left out, unless there's a compelling reason to set
it to :code:`TRUE` (which triggers the use of htmlspecialchars()).

