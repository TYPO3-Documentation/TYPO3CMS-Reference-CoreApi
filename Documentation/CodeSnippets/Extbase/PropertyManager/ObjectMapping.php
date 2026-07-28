<?php

use T3docs\BlogExample\Domain\Model\Tag;
use TYPO3\CMS\Extbase\Property\Exception;

class PostController extends AbstractController
{
    /**
     * This method demonstrates property mapping to an object
     * @throws Exception
     */
    protected function mapTagFromString(string $tagString = 'some tag'): Tag
    {
        $input = [
            'name' => $tagString,
        ];
        return $this->propertyMapper->convert(
            $input,
            Tag::class,
        );
    }
}
