:navigation-title: Extension development

..  include:: /Includes.rst.txt
..  index:: Security guidelines; Extension development
..  _security-extension-development:

============================================
Security guidelines for extension developers
============================================

TYPO3 extensions can introduce critical vulnerabilities if not securely coded.
This chapter outlines secure development practices for extension developers,
with a focus on user input handling, database queries, and protecting against
common attacks such as SQL injection and cross-site scripting (XSS).

..  contents:: Table of contents

..  index:: Security; User Input
..  _never-trust-user-input:

Never trust user input
======================

All input data your extension receives from the user can be potentially malicious.
That applies to all data being transmitted via `GET` and `POST` requests. You can never trust
where the data came from as your form could have been manipulated.
Cookies should be classified as potentially malicious as well because they may
have also been manipulated.

Always check if the format of the data corresponds
with the format you expected. For example, for a
field that contains an email address, you should check that a valid email
address was entered and not any other text.

If the backend forms use the correct TCA types like :ref:`'type' => 'email' <t3tca:columns-email>`
or parameters like :ref:`eval <t3tca:columns-input-properties-eval>`. In
Extbase the :ref:`validating framework <extbase_validation>` can
be helpful.

..  index:: Security; Database Queries
..  _create-your-own-database-queries:

Create your own database queries
================================

Queries in the query language of Extbase are automatically escaped.

However manually created SQL queries are subject to be attacked by
:ref:`SQL injection <security-sql-injection>`.

All SQL queries should be made in a dedicated class called a repository. This
applies to Extbase queries, Doctrine DBAL :ref:`QueryBuilder
<database-query-builder>` queries and pure SQL queries.

..  attention::
    **Always** escape any user input with
    :ref:`createNamedParameter() <database-query-builder-create-named-parameter>`
    in queries created by the QueryBuilder.


..  index:: Security; Trusted properties
..  _trusted-properties:

Trusted properties (Extbase Only)
==================================

..  danger::

    Be aware that request hashes (HMAC) do not protect against **Identity** field manipulation.
    An attacker can modify the identity field value and can then update the value of
    another record, even if they do not usually have access to it. You have to
    implement your own validation for the Identity field value (verify ownership
    of the record, add another hidden field that validates the identity field
    value).

In Extbase there is transparent argument mapping applied: All properties that
are to be sent are changed transparently on the object. Certainly, this
implies a safety risk, that we will explain with an example: Assume we
have a form to edit a `user` object. This object has the
properties `username, email, password` and
`description`. We want to provide the user with a form to change all
properties except the username (because the username should not be
changed in our system).

The form looks like this:

..  code-block:: html
    :caption: EXT:blog_example/Resources/Private/Templates/SomeTemplate.html

    <f:form name="user" object="{user}" action="update">
       <f:form.textbox property="email" />
       <f:form.textbox property="password" />
       <f:form.textbox property="description" />
    </f:form>

If the form is sent, the argument mapping for the user object receives
this array:

..  code-block:: none
    :caption: HTTP POST

    [
       __identity => ...
       email =>  ...
       password => ...
       description => ...
    ],

Because the :php:`__identity` property and further properties
are set, the argument mapper gets the object from the persistence layer,
makes a copy and then applies the changed properties to the object. After
this we call the :php:`update($user)` method for the
corresponding repository to make the changes persistent.

What happens if an attacker manipulates the form data and transfers
an additional field :php:`username` to the server? In this case the
argument mapping would also change the :php:`$username` property of
the cloned object - although we did not want this property to
be changed by the user itself.

To avoid this problem, Fluid creates a hidden form field :php:`__trustedProperties`
which contains information about what properties are to be trusted.
Once a request reaches the server, the property mapper of Extbase
compares the incoming fields with the property names, defined by the
:php:`__trustedProperties` argument.

As the content of said field could also be manipulated by the client, the
field contains a serialized array of trusted properties and
a hash of that array. On the server-side, the hash is also compared
to ensure the data has not been tampered with on the client-side.

Only the form fields generated by Fluid with the
appropriate ViewHelpers are transferred to the server. If an attacker
tries to add a field on the client-side, this is
detected by the property mapper, and an exception will be thrown.

In general, :php:`__trustedProperties` should work completely transparently
for you. You do not have to know how it works in detail. You have to know
this background knowledge only if you want to change data via JavaScript
or web services.


..  index::
    Security; Cross-site scripting
    Security; XSS
..  _prevent-cross-site-scripting:

Prevent cross-site scripting
============================

Fluid contains some integrated techniques to secure web applications
by default. One of the more important features is automatic
prevention against cross site scripting, a common
attack against web applications. In this section, we give you a problem
description and show how you can avoid
:ref:`cross-site scripting (XSS) <security-xss>`.

Assume you have programmed a forum. An malicious user will get access
to the admin account. To do this, they posted the following message
in the forum to try to embed JavaScript code:

..  code-block:: html
    :caption: A simple example for XSS

    <script type="text/javascript">alert("XSS");</script>

When the forum post gets displayed, if the forum's programmer
has not made any additional security precautions, a JavaScript popup "XSS" will be
displayed. The
attacker now knows that any JavaScript he writes in a post is executed
when displaying the post - the forum is vulnerable to cross-site
scripting. Now the attacker can replace the code with a more complex
JavaScript program that, for example, can read the cookies of the visitors
of the forum and send them to a certain URL.

If an administrator retrieves this prepared forum post, their session
ID (that is stored in a cookie) is transferred to the attacker. In a worst case scenario,
the attacker gets administrator privileges
(:ref:`Cross-site request forgery (XSRF) <security-xsrf>`).

How can we prevent this? We must encode all special characters with a call
of :php:`htmlspecialchars()`. With this, instead of
:html:`<script>..</script>` the safe result is delivered
to the browser:
:html:`&amp;lt;script&amp;gt;...&amp;lt;/script&amp;gt;`. So the
content of the script tag is no longer executed as JavaScript but only
displayed.

But there is a problem with this: If we forget or fail to encode input
data just once, an XSS vulnerability will exist in the system.

In Fluid, the output of every object accessor that occurs in a
template is automatically processed by :php:`htmlspecialchars()`. But
Fluid uses :php:`htmlspecialchars()` only for templates with the
extension *.html*. If you use other output formats, it is disabled, and you
have to make sure to convert the special characters correctly.

Content that is output via the ViewHelper :html:`<f:format.raw>` is not
sanitized. See
:ref:`ViewHelper Reference, format.raw <t3viewhelper:typo3fluid-fluid-format-raw>`.

..  danger::
    Never pass unescaped content, possibly supplied by users to the
    :html:`<f:format.raw>` ViewHelper!

If you want to output user provided content containing HTML tags that should
not be escaped use :html:`<f:format.html>`.

See
:ref:`ViewHelper Reference, format.html <t3viewhelper:typo3-fluid-format-html>`.

Sanitation is also deactivated for
object accessors that are used in arguments of a ViewHelper. A short
example for this:

..  code-block:: html
    :caption: EXT:blog_example/Resources/Private/Templates/SomeTemplate.html

    {variable1}
    <f:format.crop append="{variable2}">a very long text</f:format.crop>

The content of `{variable1}` is sent to
htmlspecialchars(), the content of `{variable2}` is not
changed. The ViewHelper must retrieve the unchanged data because we can not
foresee what should be done with it. For this reason, ViewHelpers
that output parameters directly have to handle special characters correctly.
