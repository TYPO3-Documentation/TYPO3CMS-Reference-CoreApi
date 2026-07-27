<?php

class Info extends AbstractEntity implements \Stringable
{
    protected string $name = '';

    protected string $bodytext = '';

    public function getCombinedString(): string
    {
        return $this->name . ': ' . $this->bodytext;
    }
}
