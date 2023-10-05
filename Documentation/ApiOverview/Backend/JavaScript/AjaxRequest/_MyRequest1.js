import AjaxRequest from "@typo3/core/ajax/ajax-request.js";

let url = 'https://example.org/my-endpoint';
// or:
let url = new URL('https://example.org/my-endpoint');

let request = new AjaxRequest(url);
