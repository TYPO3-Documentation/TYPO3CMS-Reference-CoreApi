<?php

use TYPO3\CMS\Core\DataHandling\SoftReference\SoftReferenceParserInterface;

final readonly class CheckExternalLinksToLocalPagesEventListener
{
    private const LOCAL_DOMAIN = 'example.org';
    private const TABLE_NAME = 'tt_content';
    private const FIELD_NAME = 'bodytext';

    /**
     * @param array<mixed> $record
     * @param array<mixed> $results
     * @return array<mixed>
     */
    private function parseField(array $record, array $results): array
    {
        $conf = $GLOBALS['TCA'][self::TABLE_NAME]['columns'][self::FIELD_NAME]['config'];
        foreach ($this->findAllParsers($conf) as $softReferenceParser) {
            $parserResult = $softReferenceParser->parse(
                self::TABLE_NAME,
                self::FIELD_NAME,
                $record['uid'],
                (string)$record[self::FIELD_NAME],
            );
            if (!$parserResult->hasMatched()) {
                continue;
            }
            foreach ($parserResult->getMatchedElements() as $matchedElement) {
                if (!isset($matchedElement['subst'])) {
                    continue;
                }
                $this->matchUrl(
                    (string)$matchedElement['subst']['tokenValue'],
                    $record,
                    $results,
                );
            }
        }
        return $results;
    }

    /**
     * @param array<mixed> $conf
     * @return SoftReferenceParserInterface[]
     */
    private function findAllParsers(array $conf): iterable
    {
        return $this->softReferenceParserFactory->getParsersBySoftRefParserList(
            $conf['softref'],
            ['subst'],
        );
    }
}
