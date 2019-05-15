<?php
    require BASE_DIR.'dao'.DS.'agendaDao.php';

    class agenda{

        public $idCliente = 0;
        public $nomeCliente = "";
        public $emailCliente = "";
        public $senhaCliente = "";

        public function buscaAgendamentosCliente($idCliente){
          $agn = new agendaDAO();

          $eventos = $agn->buscaAgendamentosCliente($idCliente); 
          return $eventos;
        }

        public function agendarProcedimento($dia, $empresa, $colaborador, $procedimento, $hora, $cliente){
            agendarProcedimento($dia, $empresa, $colaborador, $procedimento, $hora, $cliente);
        }

        //Relação de funções relativas a relatorios e graficos
        public function relacaoProcedimentosAgendados($colaborador, $diaInicio, $diaFim, $empresa){
            $relacaoProcedimentos = relacaoProcedimentosAgendados($colaborador, $diaInicio, $diaFim, $empresa);
            return $relacaoProcedimentos;
        }

        public function relacaoValoresAgendados($diaInicio, $diaFim){
            $valoresAgendados = relacaoValoresAgendados($diaInicio, $diaFim);
            return $valoresAgendados;
        }

        public function relacaoValoresAgendadosCliente($diaInicio, $diaFim){

            $valoresAgendadosCliente = relacaoValoresAgendadosCliente($diaInicio, $diaFim);
            return $valoresAgendadosCliente;
        }

        public function numeroAgendamentoClientePeriodo($diaInicio, $diaFim){
            $numeroAgendamentoProcedimentoCliente = numeroAgendamentoClientePeriodo($diaInicio, $diaFim);
            return $numeroAgendamentoProcedimentoCliente;
        }

        public function criaAgenda($agendaTrabalho){
            $agnDAO = new agendaDAO();

            $agnDAO->criaAgenda($agendaTrabalho);
        }
    }
?>
