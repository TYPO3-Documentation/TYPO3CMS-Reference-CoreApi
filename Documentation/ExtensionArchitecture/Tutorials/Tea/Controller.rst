..  include:: /Includes.rst.txt

..  index::
    Tutorial Tea; Controller.rst
..  _extbase_tutorial_tea_controller:

==========
Controller
==========

The controller controls the flow of data between the view and the
data repository containing the model.

A controller can contain one or more actions. Each of them is a method which
ends on the name "Action" and returns an object of type
:php:`\Psr\Http\Message\ResponseInterface`.

In the following action a tea object should be displayed in the view:

.. include:: _Controller/_ShowAction.rst.txt

This action would be displayed if an URL like the following would be requested:
:samp:`https://www.example.org/myfrontendplugin?tx_tea[action]=show&tx_tea[controller]=tea&tx_tea[tea]=42&chash=whatever`.

So where does the model :php:`Tea $tea` come from? The only reference we had
to the actual tea to be displayed was the ID :php:`42`. In most cases, the
parent class :php:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController` will take care of matching parameters to
objects or models. In more advanced scenarios it is necessary to influence
the parameter matching. But in our scenario it is sufficient to know that this
happens automatically in the controller.

The following action expects no parameters. It fetches all available tea
objects from the repository and hands them over to the view:

..  include:: _Controller/_IndexAction.rst.txt

The controller has to access the :php:`TeaRepository` to find all available tea
objects. We use :ref:`Dependency Injection <DependencyInjection>` to make the
repository available to the controller: The constructor
will be called automatically with an initialized :php:`TeaRepository` when
the :php:`TeaController` is created.

Both action methods return a call to the method :php:`$this->htmlResponse()`.
This method is implemented in the parent class :php:`ActionController` and is
a shorthand method to create a response from the response factory and attach
the rendered content. Let us have a look at what happens in this method:

..  include:: _Controller/_HtmlResponse.rst.txt

You can also use this code directly in your controller if you need to return
a different HTTP header. If a different rendering from the standard view is
necessary you can just pass the rendered HTML content to this method. There
is also a shorthand method for returning JSON called :php:`jsonResponse()`.

This basic example requires no actions that are forwarding or redirecting.
Read more about those concepts here: :ref:`extbase-action-controller-forward`.
