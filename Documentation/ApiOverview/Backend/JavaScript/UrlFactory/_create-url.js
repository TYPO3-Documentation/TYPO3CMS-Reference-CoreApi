import AjaxRequest from '@typo3/core/ajax/ajax-request.js';
import { UrlFactory } from '@typo3/core/factory/url-factory.js';

const url = UrlFactory.createUrl(
  TYPO3.settings.ajaxUrls.myextension_search,
  {
    query: 'typo3',
    // Sent as filter[type]=page
    filter: {
      type: 'page',
    },
    // Left out, as the value is null
    limit: null,
  },
);

const response = await new AjaxRequest(url).get();
