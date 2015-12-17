<?php

class Admin_Model_Auth {

    public static function login($login, $senha) {

        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        //Inicia o adaptador Zend_Auth para banco de dados
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('users')
                ->setIdentityColumn('login')
                ->setCredentialColumn('hashed_password');

        //Define os dados para processar o login
        $authAdapter->setIdentity($login)
                ->setCredential(sha1($senha));
        //Faz inner join dos dados do perfil no SELECT do Auth_Adapter
        $select = $authAdapter->getDbSelect();
        $select->joinInner('members', 'members.user_id = users.id',array('members.id')); 
        //Efetua o login
        $auth = Zend_Auth::getInstance();
        
        //SELECT array_agg(system_id) as systems FROM members AS m where m.user_id = 2 -- group by m.user_id;

        $result = $auth->authenticate($authAdapter);


       //Verifica se o login foi efetuado com sucesso
        if ($result->isValid()) {
            //Recupera o objeto do usuário, sem a senha
            $info = $authAdapter->getResultRowObject(null, 'hashed_password');
            
            Jdebug($info);

            $usuario = new Admin_Model_User();
            $usuario->setFullName($info->login);
            $usuario->setUserName($info->login);
            $usuario->setRoleId($info->nome_perfil);

            $storage = $auth->getStorage();
            $storage->write($usuario);

            return true;
        }
        throw new Exception('Nome de usuário ou senha inválida');
    }

}
