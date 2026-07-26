<?php

class GitHubLinkHandler implements LinkHandlerInterface
{
    public function canHandleLink(array $linkParts): bool
    {
        if ($linkParts['type'] !== 'github') {
            return false;
        }
        $this->linkParts = $linkParts['url'] ?? [];
        return true;
    }
}
