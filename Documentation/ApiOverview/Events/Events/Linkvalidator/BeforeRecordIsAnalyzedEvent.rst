.. include:: /Includes.rst.txt
.. index:: Events; BeforeRecordIsAnalyzedEvent
.. _BeforeRecordIsAnalyzedEvent:


===========================
BeforeRecordIsAnalyzedEvent
===========================

Event that is fired to modify results (= add results) or modify the record before the linkanalyzer analyzes
the record.

Example
=======

In this example we are checking if there are external links containing the URL
of the project itself as editors tend to set external links on internal pages
at times.

The following code can be put in a custom
:ref:`minimal extension <extension-minimal>`.

Create a class that works as event listener. This class does not implement or
extend any class. It has to provide a method that accepts an event of type
:php:`TYPO3\CMS\Linkvalidator\Event\BeforeRecordIsAnalyzedEvent`.  By default
the method is called :php:`handleEvent`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/EventListener/Linkvalidator/BeforeRecordIsAnalyzedEventListener.php

    <?php

    declare(strict_types=1);

    namespace Vendor\MyExtension\EventListener\Linkvalidator;

    use TYPO3\CMS\Linkvalidator\Event\BeforeRecordIsAnalyzedEvent;

    class BeforeRecordIsAnalyzedEventListener
    {

        public function handleEvent(BeforeRecordIsAnalyzedEvent $event): void
        {
            // do something
        }
    }

The listener must then be registered in the extensions :php:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    services:
        _defaults:
            autowire: true
            autoconfigure: true
            public: false

        Vendor\MyExtension\:
            resource: '../Classes/*'
            exclude: '../Classes/Domain/Model/*'

        Vendor\MyExtension\EventListener\Linkvalidator\BeforeRecordIsAnalyzedEventListener:
            tags:
                - name: event.listener
                  method: handleEvent
                  identifier: 'myExtensionBeforeRecordIsAnalyzedEventListener'
                  event: TYPO3\CMS\Linkvalidator\Event\BeforeRecordIsAnalyzedEvent

For the implementation we need the :php:`BrokenLinkRepository` to register
additional link errors and the :php:`SoftReferenceParserFactory` so we can
automatically parse for links. These two classes have to be injected via
:ref:`dependeny injection <Dependency-Injection>`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/EventListener/Linkvalidator/BeforeRecordIsAnalyzedEventListener.php

    use TYPO3\CMS\Core\DataHandling\SoftReference\SoftReferenceParserFactory;
    use TYPO3\CMS\Linkvalidator\Event\BeforeRecordIsAnalyzedEvent;
    use TYPO3\CMS\Linkvalidator\Repository\BrokenLinkRepository;

    final class BeforeRecordIsAnalyzedEventListener
    {
        protected BrokenLinkRepository $brokenLinkRepository;
        protected SoftReferenceParserFactory $softReferenceParserFactory;

        public function __construct(
            BrokenLinkRepository $brokenLinkRepository,
            SoftReferenceParserFactory $softReferenceParserFactory
        ) {
            $this->brokenLinkRepository = $brokenLinkRepository;
            $this->softReferenceParserFactory = $softReferenceParserFactory;
        }
    }

In this example we only check the field :sql:`bodytext` of new tables:


..  code-block:: php
    :caption: EXT:my_extension/Classes/EventListener/Linkvalidator/BeforeRecordIsAnalyzedEventListener.php

    public function handleEvent(BeforeRecordIsAnalyzedEvent $event): void
    {
        $table = $event->getTableName();
        $forbiddenDomain = 'example.org';
        if ($table == 'tx_news_domain_model_news') {
            $results = $event->getResults();
            $newsItem = $event->getRecord();
            // a quick check if the forbidden domain is contained at all
            if (strpos((string) $newsItem['bodytext'], $forbiddenDomain) !== false) {
                $field = 'bodytext';
                $conf = $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['bodytext']['config'];
                // parse the field
                foreach ($this->softReferenceParserFactory->getParsersBySoftRefParserList($conf['softref'], ['subst']) as $softReferenceParser) {
                    $parserResult = $softReferenceParser->parse($table, $field, $newsItem['uid'], $newsItem['bodytext']);
                    if (!$parserResult->hasMatched()) {
                        continue;
                    }
                    // act on each link found
                    foreach ($parserResult->getMatchedElements() as $matchedElement) {
                        // if it contains the forbidden domain, subdomains would also be allerted here
                        if ($matchedElement['subst'] && $matchedElement['subst']['tokenValue']
                            && strpos($matchedElement['subst']['tokenValue'] . '', $forbiddenDomain) !== false) {
                            // create an entry for the table tx_linkvalidator_link
                            $link = [
                                'record_uid' => $newsItem['uid'],
                                'record_pid' => $newsItem['pid'],
                                'language' => $newsItem['sys_language_uid'],
                                'field' => $field,
                                'table_name' => $table,
                                'url' => $matchedElement['subst']['tokenValue'],
                                'last_check' => time(),
                                'link_type' => 'external',
                            ];
                            // Insert it into the repository with
                            // a meaningful exception text and a unique error number
                            $this->brokenLinkRepository->addBrokenLink($link, false, [
                                'errorType' => 'exception',
                                'exception' => 'Do not link externally to ' . $forbiddenDomain,
                                'errno' => 42]);
                            // and add the item to the results
                            $results[] = $newsItem;
                        }
                    }
                }
            }
            $event->setResults($results);
        }
    }

API
---

.. include:: /CodeSnippets/Events/Linkvalidator/BeforeRecordIsAnalyzedEvent.rst.txt
