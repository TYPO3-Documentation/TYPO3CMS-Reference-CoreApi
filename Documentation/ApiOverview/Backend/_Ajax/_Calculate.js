import AjaxRequest from "@typo3/core/ajax/ajax-request.js";

// Generate a random number between 1 and 32
const randomNumber = Math.ceil(Math.random() * 32);
new AjaxRequest(TYPO3.settings.ajaxUrls.myextension_example_dosomething)
  .withQueryArguments({input: randomNumber})
  .get()
  .then(async function (response) {
    const resolved = await response.resolve();
    console.log(resolved.result);
  });
