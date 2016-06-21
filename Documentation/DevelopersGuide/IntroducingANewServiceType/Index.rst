.. include:: ../../Includes.txt


Introducing a new service type
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Every service belongs to a given service type. A service type is
represented by a key, just like an extension key. In the examples
above there was mention of the "auth" and "metaExtract" service types.

Each service type will implement its own API corresponding to the task
it is designed to handle. For example the "auth" service type requires
the two methods :code:`getUser()` and :code:`authUser()` . If you
introduce a new service type you should think well about its API
before starting development. Ideally you should discuss with other
developers. Services are meant to be reusable. A badly designed
service that is used only once is a failed service. The development
mailing list (typo3.dev) is a good place to discuss new service types.

You should plan to provide a base class for your new service type. It
is then easier to develop services based on this type as you can start
by extending the base class. You should also provide a documentation,
that describes the API. It should be clear to other developers what
each method of the API is supposed to do.

