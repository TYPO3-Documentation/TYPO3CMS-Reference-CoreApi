import AjaxRequest from "@typo3/core/ajax/ajax-request.js";

let request = new AjaxRequest('https://example.org/my-endpoint');

let queryArguments = {
  foo: 'bar',
  bar: {
    baz: ['foo', 'bencer']
  }
};
// or:
let queryArguments = new URLSearchParams({
  foo: 'bar',
  baz: {
    baz: ['foo', 'bencer']
  }
});

request = request.withQueryArguments(queryArguments);

// The query string compiles to ?foo=bar&bar[baz][0]=foo&bar[baz][1]=bencer
