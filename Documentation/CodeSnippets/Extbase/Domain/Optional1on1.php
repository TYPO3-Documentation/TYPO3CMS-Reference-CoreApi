<?php

class Post extends AbstractEntity implements \Stringable
{
    /**
     * 1:1 optional relation
     */
    protected ?Info $additionalInfo = null;

    public function getAdditionalInfo(): ?Info
    {
        return $this->additionalInfo;
    }

    public function setAdditionalInfo(?Info $additionalInfo): void
    {
        $this->additionalInfo = $additionalInfo;
    }
}
