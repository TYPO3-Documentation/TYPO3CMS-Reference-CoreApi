

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Localization
^^^^^^^^^^^^

TYPO3 is designed to be fully localizable. Hard-coded strings should
thus be avoided unless there are some technical limitations (e.g. some
early or low-level stuff where a langobject is not available).


Defining the localized strings
""""""""""""""""""""""""""""""

Here are some rules to respect when working with labels in locallang
files:

- always check the existing locallang files to see if a given localized
  string already exists, in particular EXT:lang/locallang\_common.xmland
  EXT:lang/locallang\_core.xml.

- localized strings should never be all uppercase. If this is needed,
  then appropriate methods to make them uppercase should be used where
  needed.

- localized strings must not be split into several parts to include
  stuff in their middle. Rather use a single string with
  sprintf()markers (%s, %d, etc.).

- when a localized string contains several sprintf()markers, it
  **must** use numbered arguments (e.g. %1$d).

- punctuation marks  **must** be included in the localized string –
  including trailing marks – as different punctuation marks (e.g. “?”
  and “¿”) may be used in various languages. Also some languages include
  blanks before some punctuation marks.

- localized strings are not supposed to contain HTML tags, except for
  CSH. They should be avoided whenever possible.

Once a localized string appears in a released version of TYPO3, it
cannot be changed (unless it needs grammar or spelling fixes). Nor can
it be removed. If the label a localized string has to be changed, a
new one should be introduced instead.


Using the localized strings
"""""""""""""""""""""""""""

Localized string are displayed using the available API, mostly
lang::getLL()when the corresponding locallang file is loaded and
lang::sL()otherwise. In both these methods, the second call parameter
should be left out, unless there's a compelling reason to set it to
TRUE(which triggers the use of htmlspecialchars()).

