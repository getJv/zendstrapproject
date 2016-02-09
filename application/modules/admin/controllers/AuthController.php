<?php

class Admin_AuthController extends Zendstrap_Controller_Action {

    
    
    
    public function init() {
        parent::init();
    }

    public function indexAction() {

        return $this->_helper->redirector('login');
    }

    public function loginAction() {
        

        try {
            
            $form = new Admin_Form_Login();
            $form->setAction($this->view->url(array(
                        'controller' => 'auth',
                        'action' => 'login',
                        'module' => 'admin'
            )));
            $this->view->form = $form;
            
            #Carrega formulário para primeiro acesso.
            if (!$this->getRequest()->isPost()) {
                return;
            }

            $data = $this->getRequest()->getPost();
            //Formulário corretamente preenchido?
            if (!$form->isValid($data)) {
                throw new Exception("Houve um erro com sua requisição. Tente novamente.");
            }

            $login = $form->getValue('login');
            $senha = $form->getValue('senha');
            //Admin_Model_Auth::login($login, $senha);
            $this->makeLogin($login, $senha);
            return $this->_helper->redirector->goToRoute(array('controller' => 'index','module'=>'default'), null, true);
        } catch (Exception $e) {
            $this->addWarnMessage($e->getMessage());
            /* Criar uma exception propri para dados inváçidos, para aproveitar corretamete o form populate */
            $form->populate($data);
            
        }
    }
    /**
     * Inicia o adaptador de conexao para usar o ZendAuth
     */
    private function startAuthAdapter(){
        
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        #Informa ta tabela e os campos utilizados para autenticação
        $authAdapter->setTableName('vw_users')
                ->setIdentityColumn('login')
                ->setCredentialColumn('hashed_password');
        return $authAdapter;
    }
    
    private function makeLogin($login,$senha){
        
        
        $authAdapter = $this->startAuthAdapter();
        #informa os dados para processar o login
        $authAdapter->setIdentity($login)
                ->setCredential(sha1($senha));
        #Efetua o login
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);
        #Verifica se o login foi efetuado com sucesso
        if (! $result->isValid()) { throw new Exception('Nome de usuário ou senha inválido');}
        #Recupera o objeto do usuário, sem a senha
        $info = $authAdapter->getResultRowObject(null, 'hashed_password');
        
        $user = new Admin_Model_User((array) $info);
        
        # Guardo o usuario na session
        $storage = $auth->getStorage();
        $storage->write($user);
        
        return true;
    }
    
    public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        //Jdebug(11);
        return $this->_helper->redirector->goToRoute(array('controller' => 'index','module'=>'default'), null, true);
    }

}
