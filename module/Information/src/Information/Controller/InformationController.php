<?php


namespace Information\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class InformationController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
