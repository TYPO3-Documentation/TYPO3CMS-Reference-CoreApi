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

..  seealso::
    *   `Data Transfer Objects (DTO) as a software design principle <https://docs.typo3.org/permalink/t3coreapi:concept-dto>`_
    *   `usetypo3.com: Data Transfer Objects in Extbase <https://usetypo3.com/dtos-in-extbase/>`_

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

..  _extbase-dto-example-dto-domain-model:

Converting DTOs to domain models
================================

In order to be persisted to the database a DTO has to be transferred into a
domain model.

This can be achieved by implementing a :php:`static` method converting the
DTO into a domain model:

To stay in our example above, let us assume we want to save the measurement
input of our users into the database in order to use it for statistical
purposes.

To avoid storing a float we will convert the height into centimeters.

As the static method is located in the same class it can access the protected
properties of the model directly.

..  literalinclude:: _codesnippets/Measurements.php
    :caption: EXT:bmi_calculator/Classes/Domain/ModelMeasurements.php

You can now transfer your data object into a model entity that can be saved into
the database:

..  literalinclude:: _codesnippets/CalculatorControllerSaveModel.php
    :caption: EXT:bmi_calculator/Classes/Controller/CalculatorController.php

..  _extbase-dto-example-dto-session:

Storing DTOs in the user session
================================

DTOs are volatile by nature. The moment you leave the controller action they are
gone.

Let us assume we want to remember the measurements of the user as long as they
dont close their browser window.

We can now store the DTO into the user session (See
`Session data <https://docs.typo3.org/permalink/t3coreapi:session-data>`_)
even if no frontend user is logged in.

In order to store the DTO into the session we need to serialize it, turn it
into a string. In order to load the DTO from the session we need to deserialize
it, turn it from a string back into a DTO.

..  literalinclude:: _codesnippets/MeasurementsDtoSerialization.php
    :caption: EXT:bmi_calculator/Classes/Domain/Model/Dto/Measurements.php

We can now load the measurement from the session and store changes there. In
order to have the functionality encapsulated we implement a service for it:

..  literalinclude:: _codesnippets/UserSessionService.php
    :caption: EXT:bmi_calculator/Classes/Service/UserSessionService.php

We can then inject the Service into out controller and load and store the
session data there:

..  literalinclude:: _codesnippets/CalculatorControllerSaveSession.php
    :caption: EXT:bmi_calculator/Classes/Controller/CalculatorController.php

..  _extbase-dto-example-dto-demand:

Using DTOs as demand objects
============================

DTOs can be also be used to handle instructional data. Let us assume we want
to display the measurements of previous users in a table. This table can be
sorted by weight or height and it can be filtered by different criteria.

We can use a DTO to transfer the current settings for the table and use this
DTO for filtering and sorting in the repository.
