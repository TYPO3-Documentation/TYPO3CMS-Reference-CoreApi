:navigation-title: Data transfer objects (DTO)

..  include:: /Includes.rst.txt
..  _extbase-dto:

======================================
Data transfer objects (DTO) in Extbase
======================================

A data transfer object (DTO) is a special kind of model used to transport
data between the business logic and the (Fluid) view but is not persisted
to the database.

Data objects can be validated and passed as parameters to controller actions,
just like persistable models.

A data object is defined by its values and cannot be referenced by an ID.

Forms are commonly bound to data objects. In multi-step forms, you can use
multiple data objects with distinct validation rules for each step.

..  _extbase-dto-example-dto:

Example: A BMI calculator without storage
=========================================

The body mass index (BMI) calculator in this example contains a form where users can
enter their height (in meters) and weight, and then calculate their BMI.
The measurements need to be validated but do not have to be stored in the database.

We define an object to contain and transport the measurements required for our
calculation:

..  literalinclude:: _codesnippets/MeasurementsDto.php
    :caption: EXT:bmi_calculator/Classes/Domain/Model/Dto/MeasurementsDto.php

If a constructor is defined, it will be called automatically; otherwise,
the setter methods will be invoked.

..  seealso::
    You can find the complete example on GitHub:
    https://github.com/TYPO3-Documentation/bmi_calculator

..  _extbase-dto-example-dto-usage:

Using a DTO in the controller
=============================

You can use the DTO to pass default data to the form and to receive the form
input:

..  literalinclude:: _codesnippets/CalculatorController.php
    :caption: EXT:bmi_calculator/Classes/Controller/CalculatorController.php

The DTO can also be used to transfer data to and from the business logic.

..  _extbase-dto-example-dto-validation:

DTO and validation
==================

All Extbase validators can be applied to a DTO as well as to an entity model.
The same `#[Validate(...)]` attribute can be used:

..  literalinclude:: _codesnippets/MeasurementsDtoValidation.php
    :caption: EXT:bmi_calculator/Classes/Domain/Model/Dto/MeasurementsDto.php

When an object is passed as an input parameter to a controller action that contains
invalid data (for example, a height given in centimeters and therefore larger than 2.5),
the `Error action <https://docs.typo3.org/permalink/t3coreapi:extbase-error-action>`_
is called. If you have not overridden or changed the error action, it will display
a flash message and attempt to return the user to the previous action.

You can override the default (and sometimes cryptic) error message by implementing
the following method in your controller:

..  literalinclude:: _codesnippets/CalculatorControllerErrorMessage.php
    :caption: EXT:bmi_calculator/Classes/Controller/CalculatorController.php

It is also possible to override the default error action `errorAction()`.
