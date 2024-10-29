.. include:: /Includes.rst.txt
.. index::
   pair: Extension development; Extbase

.. _extbase:

=======
Extbase
=======

Extbase is an extension framework to create TYPO3 frontend plugins and TYPO3
backend modules. Extbase can be used to develop extensions but it does not
have to be used.

Extbase is included in the TYPO3 Core as system extension :php:`extbase`.

**Please note:** Extbase relies on :ref:`frontend TypoScript <t3tsref:start>`
being present; otherwise the configuration is not applied. This is usually no
problem - Extbase plugins are typically either included as
:ref:`USER content object <t3tsref:cobj-user>` (its content is cached and
returned together with other content elements in fully-cached page context), or
the Extbase plugin is registered as USER_INT. In this case, the
TYPO3 Core takes care of calculating TypoScript before the plugin is
rendered, while other USER content objects are fetched from page cache. This in
mind you should not use Extbase in another context, like in
:ref:`middlewares <request-handling-middlewares-extbase>`.

There are also tutorials in the :ref:`Extension Development -
Tutorials <extension-tutorials>` section.

..  toctree::
    :titlesonly:

    Introduction/Index
    Reference/Index
    Examples/Index
