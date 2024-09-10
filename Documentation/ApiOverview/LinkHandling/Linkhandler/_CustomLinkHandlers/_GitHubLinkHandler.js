/**
 * Module: TYPO3/CMS/Examples/GitHubLinkHandler
 * GitHub issue link interaction
 */
define(['jquery', 'TYPO3/CMS/Recordlist/LinkBrowser'], function($, LinkBrowser) {
  'use strict';

  /**
   *
   * @type {{}}
   * @exports T3docs/Examples/GitHubLinkHandler
   */
  var GitHubLinkHandler = {};

  $(function() {
    $('#lgithubform').on('submit', function(event) {
      event.preventDefault();

      var value = $(this).find('[name="lgithub"]').val();
      if (value === 'github:') {
        return;
      }
      if (value.indexOf('github:') === 0) {
        value = value.substr(7);
      }
      LinkBrowser.finalizeFunction('github:' + value);
    });
  });

  return GitHubLinkHandler;
});
