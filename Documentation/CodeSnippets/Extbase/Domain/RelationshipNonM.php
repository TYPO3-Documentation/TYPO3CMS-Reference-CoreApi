<?php

class Post extends AbstractEntity implements \Stringable
{
    /**
     * @var Person
     */
    protected ?Person $author = null;

    protected ?Person $secondAuthor = null;
}
