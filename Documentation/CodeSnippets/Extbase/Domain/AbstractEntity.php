<?php

class Comment extends AbstractEntity implements \Stringable
{
    protected string $author = '';

    protected string $content = '';

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function __toString(): string
    {
        return $this->content;
    }
}
