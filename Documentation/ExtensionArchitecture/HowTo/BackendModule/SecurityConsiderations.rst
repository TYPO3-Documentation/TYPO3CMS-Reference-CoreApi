:navigation-title: Security Considerations

.. include:: /Includes.rst.txt
.. index:: Backend modules; Security Considerations

.. _backend-modules-security:

=======================
Security Considerations
=======================

Cross-Site-Request-Forgery (CSRF)
=================================

Overview
--------

HTTP requests are typically categorized into at least two types:

* **GET requests**: Used for retrieving data without altering the server's
  state, such as fetching webpages or performing searches.
* **POST requests**: Used for actions that modify the server's state, such
  as creating accounts, submitting forms, or updating settings.

Cross-site attacks, such as Cross-Site Request Forgery (CSRF), exploit the
trust a web application has in a user's browser by tricking it into making
unintended requests. Setting cookies (primarily these used to provide
authentication) with the `SameSite=strict` attribute can mitigate these
attacks by ensuring that cookies are only sent with same-site requests.
However, certain edge cases, such as clicking a malicious link in a
standalone mail application, can still pose a risk, as cookies might be
sent in such scenarios.

This section explains how to enforce using `POST` for state-modifying actions
to mitigate CSRF risks and provides an example backend module implementation
to demonstrate best practices.

The example below demonstrates a module that renders a list of items and
provides a delete action. The previous implementation used `GET` links with
query parameters for the delete action, which modifies the server's state.
This should be replaced with `POST` requests for improved security.

Asserting HTTP Methods in Custom Module Controllers
---------------------------------------------------

Enforcing HTTP Methods
......................

The revised example below uses dedicated target handlers for each controller
action instead of a generic `handleRequest` handler.

..  code-block:: diff
    :caption: **Revised** EXT:demo/Configuration/Backend/Modules.php
    :linenos:

      <?php
      use Example\Demo\Controller\CustomModuleController;

      return [
          'demo' => [
              'access' => 'user',
              'path' => '/module/dashboard',
              'iconIdentifier' => ...,  # Icon configuration here
              'labels' => ...,          # Label configuration here
              'routes' => [
    -             '_default' => [
    -                 'target' => CustomModuleController::class . '::handleRequest',
    -             ],
    +             '_default' => [
    +                 'target' => CustomModuleController::class . '::listAction',
    +             ],
    +             'delete' => [
    +                 'target' => CustomModuleController::class . '::deleteAction',
    +             ],
              ],
          ],
      ];

To enforce appropriate HTTP methods, the revised examples make use of the
:php:`TYPO3\CMS\Core\Http\AllowedMethodsTrait`. `GET` is enforced for
:php:`listAction`, and `POST` is required for :php:`deleteAction`.

Besides that, the vague and unspecific :php:`handleRequest` intermediate
dispatch method has been dropped in favour of having dedicated routes to
each controller action.

..  code-block:: diff
    :caption: **Revised** EXT:demo/Classes/Controller/ModuleController.php
    :linenos:

      <?php
      namespace Example\Demo\Controller;

      use Example\Demo\Domain\Repository\ThingRepository;
      use TYPO3\CMS\Backend\Routing\UriBuilder;
      use TYPO3\CMS\Backend\Template\ModuleTemplate;
    + use TYPO3\CMS\Core\Http\AllowedMethodsTrait;
      use TYPO3\CMS\Core\Http\HtmlResponse;
      use TYPO3\CMS\Core\Http\RedirectResponse;

      class CustomModuleController
      {
    +     use AllowedMethodsTrait;
    +
          public function __construct(
              protected readonly UriBuilder $uriBuilder,
              protected readonly ThingRepository $thingRepository,
              protected readonly ModuleTemplate $moduleTemplate,
          ) {}

    -     public function handleRequest(ServerRequestInterface $request): ResponseInterface
    -     {
    -         $action = $request->getQueryParams()['action']
    -             ?? $request->getParsedBody()['action']
    -             ?? 'list';
    -         return $this->{$action . 'Action'}($request);
    -     }
    -
          public function listAction(ServerRequestInterface $request): ResponseInterface
          {
    +         $this->assertAllowedHttpMethod($request, 'GET');
              $this->moduleTemplate->assignMultiple([
                  'things' => $this->thingRepository->findAll(),
              ]);
              return $this->moduleTemplate->renderResponse('CustomModule/List');
          }

          public function deleteAction(ServerRequestInterface $request): ResponseInterface
          {
    -         $thingId = $request->getQueryParams()['thing']
    -             ?? $request->getParsedBody()['thing']
    -             ?? null;
    +         $thingId = $request->getParsedBody()['thing'] ?? null;
    +         $this->assertAllowedHttpMethod($request, 'POST');

              // validate ID early
              if (!is_string($thingId) || $thingId === '') {
                  return new HtmlResponse('Bad request', 400);
              }

              $this->thingRepository->removeById((int)$thingId);

              $listRoute = $this->uriBuilder
                  ->buildUriFromRoute('demo', [], UriBuilder::ABSOLUTE_URL);
              return new RedirectResponse($listRoute);
          }
      }

Template Example
................

In the revised template, `POST`-based form buttons are used
instead of `GET` links for delete actions:

..  code-block:: diff
    :caption: **Revised** EXT:demo/Resources/Private/Templates/ExtbaseModule/List.html
    :linenos:

      <ul>
      <f:for each="{things}" as="thing">
          <li>
              {thing.name}:
    -         <a href="{f:be.uri(
    -                 route: 'demo.delete',
    -                 parameters: '{action: ‘delete’, thing: thing.uid}'
    -             )" class="btn btn-default">delete</a>
    +         <button
    +             name="thing" value="{thing.uid}"
    +             type="submit" form="demo-module-form-delete-action"
    +             class="btn btn-default">delete</button>
          </li>
      </f:for>
      </ul>
    + <form
    +     action="{f:be.uri(route: 'demo.delete')}" method="post"
    +     id="demo-module-form-delete-action" class="hidden"></form>

..  hint::

    The :html:`<button form="identifier">` references the :html:`<form id="identifier">`
    element. This allows multiple :html:`<button>` elements to be used with a single
    :html:`<form>`.

Asserting HTTP Methods in Extbase Controllers
---------------------------------------------

Enforcing HTTP Methods
......................

The following example demonstrates enforcing HTTP methods in Extbase module
controllers using :php:`AllowedMethodsTrait`:

..  code-block:: diff
    :caption: **Revised** EXT:demo/Classes/Controller/ModuleController.php
    :linenos:

      <?php
      namespace Example\Demo\Controller;

      use Example\Demo\Domain\Model\Thing;
      use Example\Demo\Domain\Repository\ThingRepository;
    + use TYPO3\CMS\Core\Http\AllowedMethodsTrait;
      use TYPO3\CMS\Backend\Template\ModuleTemplate;
      use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

      class ExtbaseModuleController extends ActionController
      {
    +     use AllowedMethodsTrait;
    +
          protected readonly ModuleTemplate $moduleTemplate;
          protected readonly ThingRepository $thingRepository;

    +     protected function initializeListAction(): void
    +     {
    +         $this->assertAllowedHttpMethod($this->request, 'GET');
    +     }
    +
          public function listAction(): ResponseInterface
          {
              $this->moduleTemplate->assignMultiple([
                  'things' => $this->thingRepository->findAll(),
              ]);
              return $this->moduleTemplate->renderResponse('ExtbaseModule/List');
          }

    +     protected function initializeDeleteAction(): void
    +     {
    +         $this->assertAllowedHttpMethod($this->request, 'POST');
    +     }
    +
          public function deleteAction(Thing $thing): ResponseInterface
          {
              $this->thingRepository->remove($thing);
              return $this->redirect('list');
          }
      }

Template Example
................

In the revised template, `POST`-based form buttons are used
instead of `GET` action links for delete actions:

..  code-block:: diff
    :caption: **Revised** EXT:demo/Resources/Private/Templates/ExtbaseModule/List.html
    :linenos:

      <ul>
      <f:for each="{things}" as="thing">
          <li>
              {thing.name}:
    -         <f:link.action
    -             name="delete" controller="Module"
    -             arguments="{thing: thing}"
    -             class="btn btn-default">delete</f:link.action>
    +         <f:form.button
    +             name="thing" value="{thing.uid}"
    +             type="submit" form="demo-module-form-delete-action"
    +             class="btn btn-default">delete</f:form.button>
          </li>
      </f:for>
      </ul>
    + <f:form
    +     action="delete" controller="Module" method="post"
    +     id="demo-module-form-delete-action" class="hidden" />

..  hint::

    The :html:`<button form="identifier">` references the :html:`<form id="identifier">`
    element. This allows multiple :html:`<button>` elements to be used with a single
    :html:`<form>`.
