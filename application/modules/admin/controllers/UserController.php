<?php

class Admin_UserController extends Zendstrap_Controller_Action
{
    protected $mapper;
     public function init() {
        parent::init();
        $this->mapper = new Admin_Model_UserMapper();
    }

    public function indexAction() {

        $this->view->paginator = $this->getPaginator($this->mapper->fetchAll()
                , $this->getRequest()->getParam('page')
                , $this->getRequest()->getParam('per_page'));
    }

    public function addAction() {
        
        if (!$this->getRequest()->isPost()) {
            return;
        }
        $form = new User_Form_System();
       $this->view->form = $form;

        

        $data = $this->getRequest()->getPost();

        try {
            if (!$form->isValid($data)) {
                throw new Exception("Houve um erro com sua requisição. Tente novamente.");
            }
            $this->mapper->save(new Admin_Model_User($data));
            $this->addSuccessMessage('Usuário registrado com sucesso.');
            return $this->_helper->redirector->goToRoute(array('controller' => 'user', 'module' => 'admin'), null, true);
        } catch (Exception $exc) {
            $this->addWarnMessage($exc->getMessage());
            $form->populate($data);
        }
    }

    public function editAction() {

        $form = new Admin_Form_System();
        $mapper = new Admin_Model_SystemMapper();
        $this->view->form = $form;



        if (!$this->getRequest()->isPost()) {

            $id = $this->getRequest()->getParam('id');
            $obj = $mapper->find($id);

            $form->populate($obj->toArray());
        } else {
            $data = $this->getRequest()->getPost();
            try {
                if (!$form->isValid($data)) {
                    throw new Exception("Preencha corretamente todos os campos.");
                }

                $mapper = new Admin_Model_SystemMapper();
                $mapper->save(new Admin_Model_System($data));
                $this->addWarnMessage('Dados atualizados com sucesso!');
                return $this->_helper->redirector->goToRoute(array('controller' => 'system', 'module' => 'admin'), null, true);
            } catch (Exception $e) {
                $this->addWarnMessage($e->getMessage());
                $form->populate($mapper->find($data['id']));
            }
        }
    }

    public function changestatusAction() {

        $form = new Admin_Form_System();
        $mapper = new Admin_Model_SystemMapper();
        try {
            if ($this->getRequest()->isPost()) {
                throw new Exception("Houve um erro de requisição. Tente novamente");
            }

            $id = $this->getRequest()->getParam('id');
            $obj = $mapper->find($id);
            if($obj->getStatus())
                $obj->setStatus(0);
            else
                $obj->setStatus(1);
            $mapper->save(new Admin_Model_System($obj->toArray()));
            $this->addWarnMessage('Dados atualizados com sucesso!');
        } catch (Exception $e) {
            $this->addWarnMessage($e->getMessage());
        }
        return $this->_helper->redirector->goToRoute(array('controller' => 'system', 'module' => 'admin'), null, true);
    }

    public function unactiveAction() {
        // action body
    }

    public
            function viewAction() {
        try {
            $id = $this->getRequest()->getParam('id');

            if ($this->getRequest()->isPost() || !is_numeric($id)) {
                throw new Exception("Houve um erro com sua requisição. Tente novamente.");
            }

            $mapper = new Admin_Model_SystemMapper();
            $obj = $mapper->find($id);
            $this->view->obj = $obj;
            /* TODO Criar o gride de 2x2 para mostrar dados e também opções */
            Jdebug($obj, 'sc');

            //return $this->_helper->redirector->goToRoute(array('controller' => 'system', 'module' => 'admin'), null, true);
        } catch (Exception $e) {
            $this->addErrorMessage($e->getMessage());

            $this->_helper->redirector('index');
        }
    }

}











