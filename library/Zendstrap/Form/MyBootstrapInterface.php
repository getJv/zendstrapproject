<?php

/**
 * Interface que contém todos os métodos que são necessários para custom
 */
interface Zendstrap_Form_MyBootstrapInterface {

    /**
     * Define a configuração da classe CSS da label e seu input para correta renderização em um formulario horizontal. Nota: a noma de colSizeLabel e colSizeField não podem ser superior a 12.
     * @param char(2) $sizeClass Usa a definição de tamanho do bootstrap, exemplo: 'sm' para small ou 'lg' para large
     * @param int $colSizeLabel Aceita int entre 1 e 12
     * @param int $colSizeFieldnd Aceita int entre 1 e 12
     * @throws Exception
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setHorizontalDisplay($sizeClass, $colSizeLabel, $colSizeField);

    /**
     * Configura o offset da label do elemento baseado em sua configuração horizontal já existente
     * @param integer $offset
     * @throws Exception
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setOffsetLabel($offsetValue);

    /**
     * Configura o offset no elemento baseado em sua configuração horizontal já existente
     * @param integer $offset
     * @throws Exception
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setOffsetField($offsetValue);

    /**
     * Permite definir uma mensagem para ser utilizada dentro do helperBlock elementeo de ajuda do bootStrap
     * @param string $message Mensagem que vai aparecer no helperblock do elemento
     * @link http://getbootstrap.com/css/#forms
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setHelperBlock($message);

    /**
     * Define a configuração CSS horizontal  para um grupo de elementos em um formulario não horizontal 
     * @param char(2) $sizeClass Usa a definição de tamanho do bootstrap, exemplo: 'sm' para small ou 'lg' para large
     * @param int $colSizeElement Aceita int entre 1 e 12
     * @throws Exception
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setHorizontalGroupFormDisplay($sizeClass, $colSizeElement);

    /**
     * Reune todas as configurações necessárias para renderizar o elemento alinhado a formatação indicada pelo bootStrap
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setBootstrapConfiguration($content = null);

    /**
     * Retorna o valor para a configuração horizontal do campo
     * @return string Classe CSS que configura a apresentação do elemento para formulários horizontais
     */
    public function getHorizontalFieldDisplay();

    /**
     * Retorna o valor para a configuração horizontal da label de um campo
     * @return string Classe CSS que configura a apresentação do elemento para formulários horizontais
     */
    public function getHorizontalLabelDisplay();

    /**
     * Retorna o valor para a configuração  do offSet da label de um campo
     * @return string Classe CSS que configura a apresentação do elemento para formulários horizontais com uso de offset
     */
    public function getOffsetLabel();

    /**
     * Retorna o valor para a configuração  do offSet de um campo
     * @return string Classe CSS que configura a apresentação do elemento para formulários horizontais com uso de offset
     */
    public function getOffsetField();

    /**
     * Recupera a mensagem de helperblock defiida para o elemento
     * @link http://getbootstrap.com/css/#forms
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function getHelperBlock();

    /**
     * retorna a configuração CSS horizontal  para um grupo de elementos em um formulario não horizontal 
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function getHorizontalGroupFormDisplay();

    /**
     * Verifica se a classe CSS para configuração do elemento dentro de um formulário horizontal foi definida
     * @return boolean
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function hasHorizontalDisplay();

    /**
     * Verifica se a classe CSS para configuração do offset do elemento dentro foi definida
     * @return boolean
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function hasOffsetField();

    /**
     * Verifica se a classe CSS para configuração do offset da label do elemento dentro foi definida
     * @return boolean
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function hasOffsetLabel();

    /**
     * Verifica se foi configurado um helperBlock para o Elemento
     * @return boolean
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function hasHelperBlock();

    /**
     * Verifica se um elemento deve ter uma apresentaçao horizontal dentro de um form com apresentação padrão
     * @return boolean
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function hasHorizontalGroupFormDisplay();
}
