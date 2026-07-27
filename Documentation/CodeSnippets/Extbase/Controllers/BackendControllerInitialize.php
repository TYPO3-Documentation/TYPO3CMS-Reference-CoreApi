<?php

class BackendController extends ActionController
{
    protected function initializeAction(): void
    {
        $this->pageUid = (int)($this->request->getQueryParams()['id'] ?? 0);
    }
}
