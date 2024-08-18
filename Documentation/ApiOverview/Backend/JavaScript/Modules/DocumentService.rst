.. include:: /Includes.rst.txt

.. _modules-documentservice:

=========================================
DocumentService (jQuery.ready substitute)
=========================================

The module :js:`TYPO3/CMS/Core/DocumentService` provides native JavaScript
functions to detect DOM ready-state returning a :js:`Promise<Document>`.

Internally the Promise is resolved when native :js:`DOMContentLoaded` event has
been emitted or when :js:`document.readyState` is defined already. It means
the initial HTML document has been completely loaded and parsed, without
waiting for stylesheets, images, and sub-frames to finish loading.


.. code-block:: javascript

   import $ from 'jquery';

   $(document).ready(() => {
     // your application code
   });

Above jQuery code can be transformed into the following using :js:`DocumentService`:

.. code-block:: javascript

   import DocumentService from '@typo3/core/document-service.js';

   DocumentService.ready().then(() => {
     // your application code
   });
