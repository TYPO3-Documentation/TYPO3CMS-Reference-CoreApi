import AjaxRequest from "@typo3/core/ajax/ajax-request.js";

let request = new AjaxRequest('https://example.org/my-endpoint');

const qs = {
  foo: 'bar',
  bar: {
    baz: ['foo', 'bencer']
  }
};
request = request.withQueryArguments(qs);

// The query string compiles to ?foo=bar&bar[baz][0]=foo&bar[baz][1]=bencer
