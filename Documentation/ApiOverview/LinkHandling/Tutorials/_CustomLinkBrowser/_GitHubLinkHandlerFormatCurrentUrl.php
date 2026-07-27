<?php

class GitHubLinkHandler implements LinkHandlerInterface
{
    public function formatCurrentUrl(): string
    {
        $issue = '';
        if (isset($this->linkParts['issue'])) {
            $issue = $this->linkParts['issue'];
        }
        return sprintf(
            'https://github.com/%s/%s/%s',
            $this->configuration['project'],
            $this->configuration['action'],
            $issue,
        );
    }
}
