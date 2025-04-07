import {SeverityEnum} from "@typo3/backend/enum/severity.js"
import MultiStepWizard from "@typo3/backend/multi-step-wizard.js"
import $ from "jquery";

export default class HelloWorldModule {
  constructor(triggerHelloWorldWizardButtonClass) {
    const buttons = document.querySelectorAll("." + triggerHelloWorldWizardButtonClass);

    buttons.forEach((button) => {
      button.addEventListener("click", () => {
        MultiStepWizard.addSlide(
          "UniqueHelloWorldIdentifier",
          "Title of the Hello World example slide",
          document.createRange().createContextualFragment("<div>Hello world</div>"),
          SeverityEnum.warning,
          "Step Hello World",
          function ($slide) {
            let $modal = $slide.closest(".modal");
            let $nextButton = $modal.find(".modal-footer").find("button[name='next']");
            MultiStepWizard.unlockNextStep();

            $nextButton.off().on("click", function () {
              // Process whatever you want from current slide, just before wizard will be closed or next slide

              // Close wizard
              MultiStepWizard.dismiss();

              // Go to next slide, if any
              // MultiStepWizard.setup.$carousel.carousel("next");
            });
          }
        );

        MultiStepWizard.show();
      });
    });
  }
}
