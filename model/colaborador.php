<?php
    require BASE_DIR.'dao'. DS . 'colaboradorDao.php' ;
 
    class colaborador{
    
        public $idColaborador = 0;
        public $nomeColaborador = "";
        public $idEmpresa = "";
    
        public function listaColaboradores($empresa){
            $colaboradores = listaColaborador($empresa); 
            return $colaboradores;
        }
    
        public function obtemDiasTrabalhoColaborador($colaborador){
            $diasTrabalho = obtemDiasTrabalhoColaborador($colaborador); 
            return $diasTrabalho;
        }
    
        public function profissionaisDisponiveisProcedimentoDataEmpresa($dia, $empresa, $procedimento){
            $profissionais = profissionaisDisponiveisProcedimentoDataEmpresa($dia, $empresa, $procedimento);
            $idSelect = "profissionais";

            montaSimplesSelectAjax($profissionais, $idSelect, 0, "getHorasDisponiveis();", "Profissional:");         
        }
    }
?>