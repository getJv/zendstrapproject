<?php

class Admin_Model_Auth {

    public static function login($login, $senha) {

        
        
        
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        #Informa ta tabela e os campos utilizados para autenticação
        $authAdapter->setTableName('vw_users')
                ->setIdentityColumn('login')
                ->setCredentialColumn('hashed_password');
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

}
