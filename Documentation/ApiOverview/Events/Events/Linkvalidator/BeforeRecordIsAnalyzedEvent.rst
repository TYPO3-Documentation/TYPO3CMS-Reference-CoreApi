..  include:: /Includes.rst.txt
..  index:: Events; BeforeRecordIsAnalyzedEvent
..  _BeforeRecordIsAnalyzedEvent:


===========================
BeforeRecordIsAnalyzedEvent
===========================

The PSR-14 event
:php:`\TYPO3\CMS\Linkvalidator\Event\BeforeRecordIsAnalyzedEvent`
allows to modify results (= add results) or modify the record
before :doc:`LinkValidator <ext_linkvalidator:Index>` analyzes the record.

Example
=======

In this example we are checking if there are external links containing the URL
of the project itself, as editors tend to set external links on internal pages
at times.

The following code can be put in a custom
:ref:`minimal extension <extension-minimal>`. You can find a live example in
our example extension
`EXT:examples <https://github.com/TYPO3-Documentation/t3docs-examples>`__.

Create a class that works as event listener. This class does not implement or
extend any class. It has to provide a method that accepts an event of type
:php:`\TYPO3\CMS\Linkvalidator\Event\BeforeRecordIsAnalyzedEvent`. By default,
the method is called :php:`__invoke`:

..  include:: /CodeSnippets/Events/Linkvalidator/BeforeRecordIsAnalyzedEvent/ExampleInvoke.rst.txt

The listener must then be registered in the extensions :php:`Services.yaml`:

..  literalinclude:: _BeforeRecordIsAnalyzedEvent/_Services.yaml
    :language: yaml
    :caption: EXT:examples/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions <dependency-injection-in-extensions>`.

For the implementation we need the
:php:`\TYPO3\CMS\Linkvalidator\Repository\BrokenLinkRepository` to register
additional link errors and the
:php:`\TYPO3\CMS\Core\DataHandling\SoftReference\SoftReferenceParserFactory` so
we can automatically parse for links. These two classes have to be injected via
:ref:`dependency injection <Dependency-Injection>`:

..  include:: /CodeSnippets/Events/Linkvalidator/BeforeRecordIsAnalyzedEvent/ExampleInject.rst.txt

Now we use the :php:`SoftReferenceParserFactory` to find all registered link
parsers for a soft reference. Then we apply each of these parsers in turn to
the configured field in the current record. For each link found we can now
match, if it is an external link to an internal page.

..  include:: /CodeSnippets/Events/Linkvalidator/BeforeRecordIsAnalyzedEvent/ParseFields.rst.txt

If the URL found in the matching is external and contains the local domain name
we add the an entry to the :php:`BrokenLinkRepository` and to the result set of
:php:`BeforeRecordIsAnalyzedEvent`.

..  include:: /CodeSnippets/Events/Linkvalidator/BeforeRecordIsAnalyzedEvent/AddToBrokenLinkRepository.rst.txt

The :php:`BrokenLinkRepository` is not an Extbase repository but a repository
based on the :ref:`Doctrine database abstraction (DBAL) <Database_Introduction>`.
Therefore, it expects an array with the names of the table fields as argument
and not an Extbase model. The method internally uses
:ref:`\\TYPO3\\CMS\\Core\\Database\\Connection::insert <database-connection-insert>`.
This method automatically quotes all identifiers and values, therefore we do not
need to worry about escaping here.

..  tip::
    It is recommended to always use a unique error number. An easy way to ensure
    the error number to be unique is to use the current Unix timestamp of the
    time of writing the code.

See the complete class here:
`CheckExternalLinksToLocalPagesEventListener <https://github.com/TYPO3-Documentation/t3docs-examples/blob/main/Classes/EventListener/LinkValidator/CheckExternalLinksToLocalPagesEventListener.php>`__.

API
===

..  include:: /CodeSnippets/Events/Linkvalidator/BeforeRecordIsAnalyzedEvent.rst.txt
