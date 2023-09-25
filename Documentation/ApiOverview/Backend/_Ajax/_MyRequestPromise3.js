import AjaxRequest from "@typo3/core/ajax/ajax-request.js";

let request = new AjaxRequest('https://example.org/my-endpoint');

const json = {foo: 'bar'};
let promise = request.post(json, {
  headers: {
    'Content-Type': 'application/json; charset=utf-8'
  }
});

promise.then(async function (response) {
}, function (error) {
  console.error(`The request failed with ${error.response.status}: ${error.response.statusText}`);
});
