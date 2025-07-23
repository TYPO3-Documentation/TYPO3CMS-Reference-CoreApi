:navigation-title: Controller

..  include:: /Includes.rst.txt
..  index:: Extbase; Controller
..  _extbase-controller:

==================
Extbase controller
==================

Extbase controllers are the main entry point for handling requests in TYPO3's
Extbase framework. They interpret incoming URLs, map and validate request data,
and delegate tasks to your domain logic through well-structured, object-oriented
code.

Controllers serve as a bridge between the request and the response:

-   They call actions based on routing.
-   They use `Dependency injection <https://docs.typo3.org/permalink/
    t3coreapi:dependency-injection>`_ to access services and repositories.
-   They validate input using the `Extbase property mapper <https://docs.typo3.org/
    permalink/t3coreapi:extbase-property-mapping>`_ and optionally apply
    additional validation rules via
    `Using validation for Extbase models and controllers <https://docs.typo3.org/
    permalink/t3coreapi:extbase-validation>`_.
-   They prepare and assign data to the
    `Extbase view <https://docs.typo3.org/permalink/t3coreapi:extbase-view>`_.
-   They return the final response – typically rendered with
    `Fluid <https://docs.typo3.org/permalink/t3coreapi:fluid>`_ templates.

Error handling is built-in via a dedicated
`Error action <https://docs.typo3.org/permalink/t3coreapi:extbase-error-action>`_,
ensuring robust and predictable behavior in case something goes wrong.

To make a controller callable, it must be registered in a plugin configuration.
This tells TYPO3 which controller and actions are available in which context.

See `Extbase plugins <https://docs.typo3.org/permalink/t3coreapi:plugins-extbase>`_
for details.

**Contents:**

..  toctree::
    :titlesonly:
    :caption: Controller

    ActionController
    ErrorAction
    PropertyMapping
    TypeConverter

..  seealso::
    If you are using the :composer:`stefanfroemken/ext-kickstarter` you can use
    command `vendor/bin/typo3 make:controller` to generate a controller.
