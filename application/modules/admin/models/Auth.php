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
        $usuario = new Admin_Model_User();
        $usuario->setFullName($info->login);
        $usuario->setUserName($info->login);
        $usuario->setRoleId('admin');
        $usuario->setUserSystems($info->systems);
        
        # Guardo o usuario na session
        $storage = $auth->getStorage();
        $storage->write($usuario);
        return true;
        

    }

}
