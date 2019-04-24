<?php
    require_once("../dao/procedimentoDao.php");
    require_once("../lib/utils.php");

    class procedimento{
    
        public $idProcedimento = 0;
        public $nomeProcedimento = "";
        public $valorProcedimento = 0;
        public $idEmpresa = 0;
    
        public function __construct(){
        
    }
    
        public function procedimentosDisponiveisDataEmpresa($dia, $empresa){
        $procedimentos = procedimentosDisponiveisDataEmpresa($dia, $empresa); 
        $idSelect = "procediments";
		
        montaSimplesSelectAjax($procedimentos, $idSelect, 0, "getProfissionais();", "Procedimento:");   
    }
}



?>