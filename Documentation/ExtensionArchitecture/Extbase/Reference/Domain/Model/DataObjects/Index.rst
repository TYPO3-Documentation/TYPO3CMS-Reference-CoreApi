:navigation-title: Data Objects

..  include:: /Includes.rst.txt
..  _extbase-dto:

======================================
Data transfer objects (DTO) in Extbase
======================================

A data transfer object (DTO) is a special kind of model that is used to transport
data between the business logic and the (Fluid) view but not persisted
to the database.

Data objects can be validated and passed as parameters to controller actions
just like persistable models.

A data object is defined by its values and cannot be passed as an ID.

Forms are commonly bound to data objects. In multi step forms you can use
multiple data objects with distinct validation for each step of the form.

..  _extbase-dto-example-dto:

Example: A BMI calculator without storage
=========================================

The body-mass index (BMI) calculator in the example has a form where users can
input their height (in meters) and weight and then calculate their BMI. The
measurements have to be validated, but not stored into the data base.

We define an object to contain and transport the measurements needed for our
calculation:

..  literalinclude:: _codesnippets/MeasurementsDto.php
    :caption: EXT:bmi_calculator/Classes/Domain/Model/Dto/MeasurementsDto.php

When there is a constructor the constructor will be called, otherwise the
setters will be called.

..  seealso::
    You can find the complete example on GitHub:
    https://github.com/TYPO3-Documentation/bmi_calculator

..  _extbase-dto-example-dto-usage:

Using a DTO in the controller
=============================

You can use the DTO to pass default data to the form and to receive the answer
from the form:

..  literalinclude:: _codesnippets/CalculatorController.php
    :caption: EXT:bmi_calculator/Classes/Controller/CalculatorController.php

The DTO can also be used to transfer logic from and to the business logic.

..  _extbase-dto-example-dto-validation:

DTO and validation
==================

All Extbase validators can be applies to a DTO as well as to an entity model.
The same `#[Validate(...)]` attribute can be used:

..  literalinclude:: _codesnippets/MeasurementsDtoValidation.php
    :caption: EXT:bmi_calculator/Classes/Domain/Model/Dto/MeasurementsDto.php

When an object is passed as input parameter to a controller action that contains
invalid data (for example the height in centimeters, therefore larger then 2.5)
the `Error action <https://docs.typo3.org/permalink/t3coreapi:extbase-error-action>`_
is called. If you did not override or change the error action, it will provide
a flash message and try to return the user to the calling action.

You can override the (cryptic) default error message by overriding the following
method in your controller:

..  literalinclude:: _codesnippets/getErrorFlashMessage.php
    :caption: EXT:bmi_calculator/Classes/Controller/CalculatorController.php

It is also possible to override the default error action `errorAction()`.
