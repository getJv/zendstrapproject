<?php

class Admin_SystemController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $mapper = new Admin_Model_SystemMapper();
        $tt     = $mapper->fetchAll();
        $tt2    = $mapper->find(1);
        $tt2->setName('JHonatan');
        $mapper->save($tt2);
        Jdebug($tt);
    }

    public function addAction()
    {
        // action body
    }

    public function editAction()
    {
        // action body
    }

    public function activeAction()
    {
        // action body
    }

    public function unactiveAction()
    {
        // action body
    }

    public function viewAction()
    {
        // action body
    }


}











