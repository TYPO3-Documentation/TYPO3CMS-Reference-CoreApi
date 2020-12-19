.. include:: /Includes.rst.txt


.. _transformations-overview:

.. _transformations-tsconfig:
.. _transformations-tsconfig-examples:
.. _transformations-tsconfig-configuration:
.. _transformations-tsconfig-configuration-disabled:
.. _transformations-tsconfig-configuration-proc:
.. _transformations-tsconfig-configuration-specific:
.. _transformations-tsconfig-processing:
.. _transformations-tsconfig-processing-overrulemode:
.. _transformations-tsconfig-processing-allowtagsoutside:
.. _transformations-tsconfig-processing-allowtags:
.. _transformations-tsconfig-processing-denytags:
.. _transformations-tsconfig-processing-blockelementlist:
.. _transformations-tsconfig-processing-htmlparser:
.. _transformations-tsconfig-processing-dontremoveunknowntags_db:
.. _transformations-tsconfig-processing-allowedclasses:
.. _transformations-tsconfig-processing-keeppdivattribs:
.. _transformations-tsconfig-processing-dontfetchextpictures:
.. _transformations-tsconfig-processing-plainimagemode:
.. _transformations-tsconfig-processing-exit_entry_htmlparser:
.. _transformations-tsconfig-processing-user:

=======================
Transformation overview
=======================

The transformation of the content can be configured by listing which
*transformation filters* to pass it through. The order of the list is
the order in which the transformations are performed when saved to the
database. The order is reversed when the content is loaded into the
RTE again.

Processing can also be overwritten by Page TSconfig, see the
:ref:`according section of the Page TSconfig reference <t3tsconfig:pageTsRte>` for details.


.. index:: Rich text editor; Transformation filters
.. _transformations-overview-filters:

Transformation filters
======================

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Transformation filter
         css\_transform

   Description
         Transforms the html markup either for display in the richtext editor or for saving in the db.
         The name "css_transform" is historical; earlier TYPO3 versions had a long since removed
         "ts_transform" mode, which basically only saved a minimum amount of HTML in the db and
         produced a lot of nowadays outdated markup like :code:`<font>` tag style rendering in the
         frontend.


.. container:: table-row

   Transformation filter
         ts\_links

   Description
         Processes anchor tags and resolves them via :code:`\TYPO3\CMS\Core\LinkHandling\LinkService`
         before saving them to the db, while using the TYPO3-internal t3:// syntax.

.. ###### END~OF~TABLE ######


.. _transformations-overview-meta:


In addition, it is possible to define :ref:`custom transformations <transformations-custom>`
can be created allowing your to add your own tailor made transformations with a PHP class where you
can program how content is processed to and from the database.

