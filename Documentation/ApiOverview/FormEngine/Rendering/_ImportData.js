/**
 * Module: TYPO3/CMS/Something/ImportData
 *
 * JavaScript to handle data import
 * @exports TYPO3/CMS/Something/ImportData
 */
define(function () {
  'use strict';

  /**
   * @exports TYPO3/CMS/Something/ImportData
   */
  var ImportData = {};

  /**
   * @param {int} id
   */
  ImportData.import = function (id) {
    $.ajax({
      type: 'POST',
      url: TYPO3.settings.ajaxUrls['something-import-data'],
      data: {
        'id': id
      }
    }).done(function (response) {
      if (response.success) {
        top.TYPO3.Notification.success('Import Done', response.output);
      } else {
        top.TYPO3.Notification.error('Import Error!');
      }
    });
  };

  /**
   * initializes events using deferred bound to document
   * so Ajax reloads are no problem
   */
  ImportData.initializeEvents = function () {

    $('.importData').on('click', function (evt) {
      evt.preventDefault();
      ImportData.import($(this).attr('data-id'));
    });
  };

  $(ImportData.initializeEvents);

  return ImportData;
});
