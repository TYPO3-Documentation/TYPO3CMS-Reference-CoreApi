..  include:: /Includes.rst.txt
..  _authentication-service:

=======================
Authentication services
=======================

The TYPO3 Core uses :ref:`Services <services>` for the authentication process.
This family of services (of type "auth") are the only Core usage that consumes the
Services API.

The aim of this chapter is to describe the authentication
services so that developers feel confident about writing
their own.

..  toctree:: Subpages
    :glob:
    :titlesonly:

    *

..  _authentication-why-services:

Why Use Services?
=================

Services provide the flexibility needed for such a complex
process of authentication, where many methods may be desirable
(single sign-on, IP-based authentication, third-party servers
such as LDAP, etc.) depending on the context.

The ease with which such services can be developed is a strong
point in favor of TYPO3, especially in corporate environments.

Being able to toy with priority and quality allows for
precise fine-tuning of the authentication chain.

Alternative services are available in the TYPO3 Extension Repository.
It is thus possible to find solutions for using LDAP as an
authentication server, for example.

You can check which authentication services are installed
using the :guilabel:`System > Reports > Installed Services`
view:

..  include:: /Images/AutomaticScreenshots/Authentication/InstalledAuthServices.rst.txt

..  note::

    For the :guilabel:`Reports` module to be visible, the system extension
    reports has to be installed. You can install it via Composer:

    ..  code-block:: bash

        composer require typo3/cms-reports

..  index::
    Authentication; Process
    BackendUserAuthentication
    FrontendUserAuthentication
    AbstractUserAuthentication

..  _authentication-process:

The Authentication Process
==========================

The authentication process is not managed entirely by services.
It is handled essentially by class
:php:`\TYPO3\CMS\Core\Authentication\BackendUserAuthentication`
for the backend (BE) and by class
:php:`\TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication`
for the frontend (FE), which both inherit from class
:php:`\TYPO3\CMS\Core\Authentication\AbstractUserAuthentication`.
The objects for these classes are available via
:php:`$GLOBALS['BE_USER']` for :php:`BackendUserAuthentication` and
:ref:`"frontend.user" request attribute <typo3-request-attribute-frontend-user>`
for :php:`FrontendUserAuthentication`.

These classes are called by the
:ref:`bootstrapping process <bootstrapping>`.
They manage the workflow of the authentication process.
Services are used strictly to identify and validate
users based on whatever form of credentials a given service
relies on (by default, a username and a password).

The authentication process kicks in on every page request,
be it in the FE or the BE. However if a valid session already exists,
that session is kept. Strictly speaking, no authentication
is performed in such a case.

..  note::
    When no session exists, the authentication process is triggered
    by a login request. In the frontend, this happens when a form field
    called `logintype` is submitted with value `login`. The same
    happens for the backend, but with a form field called `login_status`.

    A :ref:`CSRF-like request token handling <authentication-request-token>`
    is in place to mitigate potential cross-site requests on actions with
    side effects

`JSON Web Tokens (JWT) <https://jwt.io/>`__ are used to transport user
session identifiers in `be_typo_user` and `fe_typo_user` cookies.

Using JWT's `HS256` (HMAC signed based on SHA256) allows to determine whether a
session cookie is valid before comparing with server-side stored session data.
This enhances the overall performance a bit, since sessions cookies would be
checked for every request to TYPO3's backend and frontend.

The session cookies can be pre-validated without querying the database, which
can filter invalid requests and might improve overall performance a bit.

As a consequence session tokens are not sent "as is", but are wrapped in a
corresponding JWT message, which contains the following payload:

*   `identifier` reflects the actual session identifier
*   `time` reflects the time of creating the cookie (RFC 3339 format)


..  index:: Authentication; Login data
..  _authentication-data:

The login data
==============

There is a typical set of data that is transmitted to authentication
service in order to enable them to do their work:

uname
    This is the user name. This can be whatever makes sense for the
    available authentication services. For the default service, this
    will match data from the "username" column of the "be_users" or
    "fe_users" table for BE or FE authentication respectively.

uident
    This is the password, possibly encrypted.

uident\_text
    This is the clear text value of the password. If the password is
    originally submitted in clear text, both "uident" and "uident\_text"
    contain the same value.

Inside an authentication service, this data is available in
:php:`$this->login`.

..  index:: Authentication; Services API
..  _authentication-api:

The "auth" services API
=======================

The services of type "auth" are further divided into subtypes,
which correspond to various steps in the authentication process.
Most subtypes exist for both FE and BE and are differentiated
accordingly.

To each subtype corresponds a part of the "auth" services public
API. They are listed below in the order in which they are called
during the authentication process.

processLoginDataBE, processLoginDataFE
    This subtype performs preprocessing on the submitted
    :ref:`login data <authentication-data>`.

    The method to implement is :php:`processLoginData()`.

..  versionchanged:: 14.0
    The parameter :php:`$passwordTransmissionStrategy` of the function
    :php:`TYPO3\CMS\Core\Authentication\processLoginData` has been removed.
    Additionally, the function does now use a strict return type.

    It receives as the only argument the login data and returns the boolean
    value :php:`true`, when the login data has been successfully processed.

    It may also return a numerical value equal to 200 or greater,
    which indicates that no further login data processing should
    take place (see :ref:`The service chain <authentication-service-chain>`).

    In particular, this subtype is implemented by the TYPO3 Core
    :php:`AuthenticationService`, which trims the given login data.

getUserFE, getUserBE
    This subtype corresponds to the operation of searching in the
    database if the credentials that were given correspond to an
    existing user. The method to implement is :php:`getUser()`.
    It is expected to return an array containing the user information
    or :php:`false` if no user was found.

authUserFE, authUserBE
    This subtype performs the actual authentication based on the
    provided credentials. The method to implement is :php:`authUser()`.
    It receives the user information (as returned by :php:`getUser()`)
    as an input and is expected to return a numerical value,
    :ref:`which is described later <authentication-service-chain>`.

..  note::

    Before any of the above-mentioned methods are called, the authentication
    process will call the :php:`initAuth()` method of each service. This
    sets up a lot of data for the service. It also makes it possible to
    override part of the default settings with
    :ref:`service-specific options <services-configuration-service-configuration>`.

    This represents very advanced tuning and is not described here.
    Please refer to
    :php:`\TYPO3\CMS\Core\Authentication\AbstractAuthenticationService::initAuth()`
    to learn more about the possibilities offered during authentication services
    initialization.


..  index:: Authentication; Service chain
..  _authentication-service-chain:

The service chain
=================

No matter what subtype, authentication services are always called
in a :ref:`chain <services-using-services-service-chain>`. This means that
**all** registered "auth" services will be called, in order of
decreasing priority and quality.

However, for some subtypes, there are ways to stop the chain.

For "processLoginDataBE" and "processLoginDataFE" subtypes, the
:php:`processLoginData()` method may return a numerical value of 200
or more. In such a case no further services are called and login data is
not further processed. This makes it possible for a service to perform
a form of final transformation on the login data.

For "authUserFE" and "authUserBE" subtypes, the :php:`authUser()` method may
return different values:

..  warning::

    Previously, there was an error in the documentation. It did not match
    the actual behaviour. This has now been fixed. For details, see
    :issue:`91993`.

*   a negative value or 0 (<=0) indicates that the authentication has
    definitely **failed** and that no other "auth" service should be
    called up.
*   a value larger than 0 and smaller than 100 indicates that the authentication
    was **successful**, but that further services should also perform their
    own authentication.
*   a value of 100 or more (>= 100) indicates that the user was **not authenticated**,
    this service is not responsible for the authentication and that further
    services should authenticate.
*   a value of 200 or more (>=200) indicates that the authentication was **successful**
    and that **no further tries** should be made by other services down
    the chain.

+------------+--------------+--------------+--------------+
|            | auth failed  | auth success | no auth      |
+============+==============+==============+==============+
| continue   |              | 1..99        | 100..199     |
+------------+--------------+--------------+--------------+
| stop       | <= 0         | >= 200       |              |
+------------+--------------+--------------+--------------+

For "getUserFE" and "getUserBE" subtypes, the logic is reversed.
The service chain will stop as soon as one user is found.

..  index:: Authentication; Development
..  _authentication-service-development:

Developing an authentication service
====================================

Use the :ref:`services-developer-service-api` to implement your service class.
When developing your own "auth" services, the chances are high
that you will want to implement only the "getUser\*" and "authUser\*"
subtypes.

There are several public extensions providing such services, so you should
be able to find examples to inspire and guide you. Anyway authentication
services can be very different from one another, so it wouldn't make much
sense to try and provide an example in this manual.

One important thing to know is that the TYPO3 authentication
process *needs* to have users inside database records ("fe_users" or
"be_users"). This means that if you interface with a third-party
server, you will need to create records on the TYPO3 side. It is
up to you to choose whether this process happens on the fly (during
authentication) or if you want to create an import process (as a
Scheduler task, for example) that will synchronize users between
TYPO3 and the remote system.

..  note::

    You probably do not want to store the actual password of imported
    users in the TYPO3 database. It is recommended to store
    an arbitrary string in such case, making sure that such string
    is random enough for security reasons. TYPO3 provides method
    :php:`\TYPO3\CMS\Core\Crypto\Random::generateRandomHexString()`
    which can be used for such a purpose.

For the :php:`authUser()` method, you will want to take care
about the return values. If your service should be the final
authority for authentication, it should not only have a high priority,
but also return values which stop the service chain (i.e.
a negative value for failed authentication, 200 or more for a
successful one). On the other hand, if your service is an alternative
authentication, but should fall back on TYPO3 if unavailable,
you will want to return 100 on failure, so that the default service
can take over.

Things can get a bit hairy if you have a scenario with mixed sources,
for example some users come from a third-party server but others
exist only in TYPO3. In such a case, you want to make sure that
your service returns definite authentication failures only for those
users which depend on the remote system and let the default
authentication proceed for "local" TYPO3 users.

..  _authentication-advanced-options:

Advanced Options
================

There are some special configuration options which can be used
to modify the behaviour of the authentication process. Some
impact the inner working of the services themselves, others
influence when services are called.

It is possible to force TYPO3 to go through the
authentication process for **every** request no matter any
existing session. By setting the following local configuration
either for the FE or the BE:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['BE_alwaysFetchUser'] = true;
    $GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['BE_alwaysAuthUser'] = true;

    $GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['FE_alwaysFetchUser'] = true;
    $GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['FE_alwaysAuthUser'] = true;

the authentication process will be fully run on each request. Both flags
may not be necessary depending on what your service does exactly.

..  note::

    This would be an appropriate setting for an IP-based authentication
    service, as it would revalidate the IP address upon each request.

A more fine-grained approach allows for triggering the
authentication process only when a valid session does not
yet exist. The settings are:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['BE_fetchUserIfNoSession'] = true;
    $GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['FE_fetchUserIfNoSession'] = true;

..  note::

    This could be used in a scenario where users go through a login portal
    and then choose to access the TYPO3 backend, for example. In such a case
    we would want the users to be automatically authenticated, but would not
    need to repeat the process upon each request.

The authentication process can also be forced to go through
all services for the "getUser\*" subtype by setting:

..  code-block:: php
    :caption: config/system/additional.php | typo3conf/system/additional.php

    $GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['BE_fetchAllUsers'] = true;
    $GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['FE_fetchAllUsers'] = true;

for BE or FE respectively. This will collect all possible users rather than
stopping at the first one available.
