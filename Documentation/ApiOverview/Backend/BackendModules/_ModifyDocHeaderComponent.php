<?php

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class BackendController extends ActionController
{
  private function modifyDocHeaderComponent(
    ModuleTemplate $view,
    string &$context,
  ): void {
    $menu = $this->buildMenu($view, $context);
    $view->getDocHeaderComponent()->getMenuRegistry()->addMenu($menu);

    $buttonBar = $view->getDocHeaderComponent()->getButtonBar();
    $this->addButtons($buttonBar);

    $pageRecord = $this->getPageRecord();
    if (is_array($pageRecord)) {
      $view->getDocHeaderComponent()->setPageBreadcrumb($pageRecord);
    }
  }

  protected function initializeModuleTemplate(
    ServerRequestInterface $request,
  ): ModuleTemplate {
    $view = $this->moduleTemplateFactory->create($request);

    $context = '';
    $this->modifyDocHeaderComponent($view, $context);
    $view->setFlashMessageQueue($this->getFlashMessageQueue());
    $title = $this->getLanguageService()
        ->sL('blog_example.module.mod:mlang_tabs_tab');
    $view->setTitle($title, $context);

    return $view;
  }
}
