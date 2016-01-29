<?php

/**
 * Description of myDataGridUtils
 *
 * @author jhonatan.morais <jhonatanvinicius@gmail.com>
 */
class Zendstrap_scripts_DataGridUtils {

    protected $columNames = array();
    protected $dataArray = null;
    protected $actions = null;
    protected $actionOnLeft = null;
    protected $cssTable = "table display table-striped";
    protected $idtable = null;

    public function __construct($columNames, $dataArray, array $actions = null, $actionOnLeft = false) {



        $this->setColumnNames($columNames);
        $this->dataArray = $dataArray;
        $this->actions = $actions;
        $this->actionOnLeft = $actionOnLeft;
         
    }

    public function setColumnNames($colunName) {

        if (is_array($colunName)) {
            foreach ($colunName as $name)
                $this->columNames[] = $name;
        } else {
            $this->columNames[] = $name;
        }
    }
    
    

    public function getColumnNames() {
        return $this->columNames;
    }

    public function __toString() {

        return $this->tableOpen() . $this->tableHeader() . $this->tablebody() . $this->tableClose();
    }

    private function idGenarate() {

        if (is_null($this->idtable))
            return substr(md5(time()), 28);
        return $this->idtable;
    }

    private function tableOpen() {

        return "<table id='{$this->idGenarate()}' class='$this->cssTable'>";
    }

    private function tableClose() {

        return "</table>" . $this->JsDataGrid();
    }

    private function JsDataGrid() {

        $jsConfig = <<<CFG
<script>
    $(document).ready(function() { 
        $('table.display').DataTable({
            language: {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
         }
    } );
} );
</script>
CFG;
        return $jsConfig;
    }

    private function tableHeader() {

        $theader = '<thead>{{value}}</thead>';
        $tfooter = '<tfoot>{{value}}</tfoot>';

        $trth = '<tr>';
        if ($this->showActionColumn() == 'l')
            $trth .= "<th> Ações </th>";
        foreach ($this->columNames as $key => $entry):
            $trth .= "<th> $entry </th>";
        endforeach;
        if ($this->showActionColumn() == 'r')
            $trth .= "<th> Ações </th>";


        $trth .= '</th>';
        return str_replace('{{value}}', $trth, $theader) . str_replace('{{value}}', $trth, $tfooter);
    }

    private function showActionColumn() {

        if ($this->actionOnLeft && !is_null($this->actions))
            return 'l';

        if (!$this->actionOnLeft && !is_null($this->actions))
            return 'r';

        return '';
    }

    private function showActionOption() {
        $trtd = "<th><span class='actions'>";
        foreach ($this->actions as $act)
            $trtd .= $act . "&nbsp;";
        return $trtd .='</span></th>';
    }

    private function tablebody() {

        $tbody = '<tbody>{{value}}</tbody>';
        $trtd = '';

        foreach ($this->dataArray as $key => $entries):


            $trtd .= '<tr>';
            if ($this->showActionColumn() == 'l')
                $trtd .= $this->showActionOption();
            foreach ($entries as $rawColumn => $customColumn):

                $trtd .= "<td> $customColumn </td>";
            endforeach;
            if ($this->showActionColumn() == 'r')
                $trtd .= $this->showActionOption();
            $trtd .= '</tr>';

        endforeach;

        return str_replace('{{value}}', $trtd, $tbody);
    }

}
