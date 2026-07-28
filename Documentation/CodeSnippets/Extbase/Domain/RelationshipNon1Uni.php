<?php

class Post extends AbstractEntity
{
    /**
     * @var Person
     */
    protected Person $author;

    protected Person|null $secondAuthor;
}
