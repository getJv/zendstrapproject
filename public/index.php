<?php
/*TODO Local temporario para esta função. retirar daqui ao final do desenvolvimento*/
/**
 * Função de debug Raw do Jhonatan.
 * $typeShow = 's' para print_r simples + exit.
 * $typeShow = 'sc' para print_r simples - exit.
 * $typeShow = 'c' para print_r + methodos + variaveis + exit
 * $typeShow = 'cc' para print_r + methodos + variaveis - exit
 * 
 * @param $var mixed
 * @param $typeShow char
 */
 function Jdebug($var,$typeShow = 's'){
 	echo '<pre>';
        
 	switch ($typeShow){
 		
 		case 's':
 			echo "#### Saída do ".get_class($var)." ####".PHP_EOL; print_r($var); 
 			exit;
 			break;
 		case 'sc':
 			echo "#### Saída de ".get_class($var)." ####".PHP_EOL; print_r($var); 
 			break;
 		
 		case 'c':
 			echo "#### Saída de ".get_class($var)." ####".PHP_EOL; print_r($var);
 			echo "#### Variáveis disponíveis em ".get_class($var)." ####".PHP_EOL; print_r(get_class_vars(get_class($var)));
 			echo "#### Métodos disponíveis em ".get_class($var)." ####".PHP_EOL; print_r(get_class_methods($var)); 
 			exit;
 			break;
 		
 		case 'cc':
 			echo '#### Saída de '.get_class($var).' ####'.PHP_EOL; print_r($var);
 			echo '#### Variáveis disponíveis em '.get_class($var).' ####'.PHP_EOL; print_r(get_class_vars(get_class($var)));
 			echo '#### Métodos disponíveis em '.get_class($var).' ####'.PHP_EOL; print_r(get_class_methods($var)); 
 			break;
                case 'om':
 			echo '#### Métodos disponíveis em '.get_class($var).' ####'.PHP_EOL; print_r(get_class_methods($var)); exit;
 			break;
 		 		
 	}
 	echo '</pre>';
 	
 	
 }
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();