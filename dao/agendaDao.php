<?php

    class agendaDao{

        // cria a agenda de colaboradores para um dado período
        function criaAgenda($agendaTrabalho){

        //Abre conexao com banco de dados
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {

            $catsSize = count( $agendaTrabalho );
            for ( $i = 1; $i <= $catsSize; $i++ ){

                $sql = "INSERT INTO agendamento 
                                    (
                                     idempresa,
                                     idcolaborador,
                                     dia,
                                     hora,
                                     livre)
                             VALUES  ("
                                     .$agendaTrabalho[$i]['empresa'].", "
                                     .$agendaTrabalho[$i]['colab'].", '"
                                     .$agendaTrabalho[$i]['dia']."', '"
                                     .$agendaTrabalho[$i]['hora']."', "
                                     .$agendaTrabalho[$i]['livre'].")";
                
            
                $exec = $conexao->query($sql);
            }
            
            mysqli_close($conexao);
          }
          else{
              echo "<h4 class='error'> Erro: "
                  . $conexao->connect_errno
                  ."</h4>";
          }
    }

        // Obtem as horas disponiveis de um colaborador em um determinado dia
        function horasDisponiveis($dia, $empresa, $colaborador){
                                   
        $horas = array();
 
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = " SELECT hora 
                       FROM agendamento 
                      WHERE idempresa = $empresa
                        AND dia = '$dia'
						AND livre = 1
                        AND idcolaborador = $colaborador;";
 
            $exec = $conexao->query($sql); 
 
            $i = 1;
            while ( $f = $exec->fetch_object() )
            {
                $horas[$i]['nome'] = $f->hora;
                $i++;
            }
                            
            mysqli_close($conexao);
            return ($horas);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }
    }

        // Atualiza a agenda com a reserva do dia pelo cliente
        function agendarProcedimento($dia, $empresa, $colaborador, $procedimento, $hora, $cliente){
                                   
        $horas = array();
 
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = " UPDATE agendamento
						SET livre = false
							, idprocedimento=$procedimento
							, idcliente = $cliente
                      WHERE idempresa = $empresa
                        AND idcolaborador = $colaborador
                        AND dia = '$dia'
						AND hora = '$hora';";
 
            $exec = $conexao->query($sql); 
 
            //$i = 1;
            //while ( $f = $exec->fetch_object() )
            //{
            //    $horas[$i]['nome'] = $f->hora;
            //    $i++;
            //}
                            
            mysqli_close($conexao);
            //return ($horas);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }
    }
	
        //Busca todos os agendamentos de um determinado cliente
        function buscaAgendamentosCliente($cliente){
                                   
        $eventos = array();
 
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = "SELECT  ag.idagendamento
                            ,em.nomeempresa as empresa
                            ,cl.nomecolaborador as profissional
                            ,ag.dia as dia
                            ,ag.hora as hora
                            ,pr.nomeprocedimento as procedimento
                       FROM agendamento ag
                 INNER JOIN colaborador cl ON cl.idcolaborador = ag.idcolaborador 
                 INNER JOIN cliente ct ON ct.idcliente = ag.idcliente 
                 INNER JOIN procedimento pr ON pr.idprocedimento = ag.idprocedimento 
                 INNER JOIN empresa em ON em.idempresa = ag.idempresa 
                      WHERE ag.livre=false 
                        AND ag.idcliente=$cliente;";

            $exec = $conexao->query($sql); 
 
            $i = 1;
            while ( $f = $exec->fetch_object() )
            {
                $eventos[$i]['procedimento'] = $f->procedimento;
                $eventos[$i]['empresa'] = $f->empresa;
                $eventos[$i]['dia'] = $f->dia;
                $eventos[$i]['hora'] = $f->hora;
                
                $i++;
            }
                            
            mysqli_close($conexao);
            return ($eventos);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }        
    }


        //Busca para uma determinada data todos os procedimentos agendados para um profissional
        function relacaoProcedimentosAgendados($colaborador, $diaInicio, $diaFim, $empresa){
        $procedimentosAgendados = array();
 
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = "    SELECT agn.dia as dia
                               , agn.hora as hora
                               , agn.idcolaborador as idColaborador
                               , agn.idcliente as idCliente
                               , cli.nomecliente as nomeCliente
                               , agn.idprocedimento as idProcedimento
                               , prc.nomeprocedimento as nomeProcedimento
                               , prc.valorprocedimento as valorProcedimento
                          FROM agendamento agn
                    INNER JOIN procedimento prc on prc.idprocedimento = agn.idprocedimento
                    INNER JOIN cliente cli on cli.idcliente = agn.idcliente
                         WHERE agn.livre = 0
                           AND agn.idempresa = $empresa
                           AND agn.cancelado = 0
                           AND agn.idcolaborador = $colaborador
                           AND agn.dia BETWEEN '$diaInicio'  AND '$diaFim'
                      ORDER BY dia;";


            $exec = $conexao->query($sql); 
 
            $i = 1;
            while ( $f = $exec->fetch_object() )
            {
                $procedimentosAgendados[$i]['dia'] = $f->dia;
                $procedimentosAgendados[$i]['hora'] = $f->hora;
                $procedimentosAgendados[$i]['idColaborador'] = $f->idColaborador;
                $procedimentosAgendados[$i]['idCliente'] = $f->idCliente;
                $procedimentosAgendados[$i]['nomeCliente'] = $f->nomeCliente;
                $procedimentosAgendados[$i]['idProcedimento'] = $f->idProcedimento;
                $procedimentosAgendados[$i]['nomeProcedimento'] = $f->nomeProcedimento;
                $procedimentosAgendados[$i]['valorProcedimento'] = $f->valorProcedimento;
                $i++;
            }
                            
            mysqli_close($conexao);
            return ($procedimentosAgendados);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }    
    }

        //Relação de valores agendados por periodo para cada colaborador
        function relacaoValoresAgendados($diaInicio, $diaFim){
       $valoresAgendados = array();
 
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = " SELECT agn.idcolaborador as idColaborador
                            , col.nomecolaborador as nomeColaborador
                            , SUM(prc.valorprocedimento) as valor 
                       FROM agendamento agn
                 INNER JOIN procedimento prc on prc.idprocedimento = agn.idprocedimento
                 INNER JOIN colaborador col on col.idcolaborador = agn.idcolaborador
                      WHERE agn.livre = 0
                        AND agn.idempresa = 1
                        AND agn.cancelado = 0
                        AND agn.dia BETWEEN '$diaInicio' AND '$diaFim'
                   GROUP BY agn.idcolaborador
                   ORDER BY Valor DESC;";


            $exec = $conexao->query($sql); 
 
            $i = 1;
            while ( $f = $exec->fetch_object() )
            {
                $valoresAgendados[$i]['idColaborador'] = $f->idColaborador;
                $valoresAgendados[$i]['nomeColaborador'] = $f->nomeColaborador;
                $valoresAgendados[$i]['valor'] = $f->valor;
                $i++;
            }
                            
            mysqli_close($conexao);
            return ($valoresAgendados);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }    
        
    }

        //Relação de valores agendados por período por cada cliente
        function relacaoValoresAgendadosCliente($diaInicio, $diaFim){
    
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = "SELECT agn.idcliente as idCliente
                           , cli.nomecliente as nomeCliente
                           , SUM(prc.valorprocedimento) as valor 
                      FROM agendamento agn
                INNER JOIN procedimento prc on prc.idprocedimento = agn.idprocedimento
                INNER JOIN cliente cli on cli.idcliente = agn.idcliente
                     WHERE agn.livre = 0
                       AND agn.idempresa = 1
                       AND agn.cancelado = 0
                       AND agn.dia BETWEEN '$diaInicio' AND '$diaFim'
                  GROUP BY agn.idcliente
                  ORDER BY Valor DESC;";


            $exec = $conexao->query($sql); 
 
            $valoresAgendadosClientes = array();
 
            $i = 1;
            while ( $f = $exec->fetch_object() )
            {
                $valoresAgendadosClientes[$i]['idCliente'] = $f->idCliente;
                $valoresAgendadosClientes[$i]['nomeCliente'] = $f->nomeCliente;
                $valoresAgendadosClientes[$i]['valor'] = $f->valor;

                
                $i++;
            }
                            
            mysqli_close($conexao);
            return ($valoresAgendadosClientes);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }    
        
        
    }

        //Numeros de agendamento por clientes por periodo
        function numeroAgendamentoClientePeriodo($diaInicio, $diaFim){
      $numeroAgendamentoProcedimentoCliente = array();
 
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = " SELECT agn.idcliente as idCliente
		                    , cli.nomecliente as nomeCliente
                            , agn.idprocedimento as idProcedimento
                            , prc.nomeprocedimento as nomeProcedimento
                            , count(agn.idprocedimento) as numeroProcedimento
                       FROM agendamento agn
                 INNER JOIN cliente cli on cli.idcliente = agn.idcliente
                 INNER JOIN procedimento prc on prc.idprocedimento = agn.idprocedimento
                      WHERE agn.livre = 0
                        AND agn.idempresa = 1
                        AND agn.cancelado = 0
                        AND agn.dia BETWEEN '$diaInicio' AND '$diaFim'
                   GROUP BY agn.idcliente, agn.idprocedimento
                   ORDER BY agn.idcliente, agn.idprocedimento;";


            $exec = $conexao->query($sql); 
 
            $i = 1;
            while ( $f = $exec->fetch_object() )
            {
                $numeroAgendamentoProcedimentoCliente[$i]['idCliente'] = $f->idCliente;
                $numeroAgendamentoProcedimentoCliente[$i]['nomeCliente'] = $f->nomeCliente;
                $numeroAgendamentoProcedimentoCliente[$i]['idProcedimento'] = $f->idProcedimento;
                $numeroAgendamentoProcedimentoCliente[$i]['nomeProcedimento'] = $f->nomeProcedimento;
                $numeroAgendamentoProcedimentoCliente[$i]['numeroProcedimento'] = $f->numeroProcedimento;
                $i++;
            }
                            
            mysqli_close($conexao);
            return ($numeroAgendamentoProcedimentoCliente);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }    
 
    }
    }

    // cria a agenda de colaboradores para um dado período
    function criaAgenda($agendaTrabalho){

        //Abre conexao com banco de dados
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {

            $catsSize = count( $agendaTrabalho );
            for ( $i = 1; $i <= $catsSize; $i++ ){

                $sql = "INSERT INTO agendamento 
                                    (
                                     idempresa,
                                     idcolaborador,
                                     dia,
                                     hora,
                                     livre)
                             VALUES  ("
                                     .$agendaTrabalho[$i]['empresa'].", "
                                     .$agendaTrabalho[$i]['colab'].", '"
                                     .$agendaTrabalho[$i]['dia']."', '"
                                     .$agendaTrabalho[$i]['hora']."', "
                                     .$agendaTrabalho[$i]['livre'].")";
                
            
                $exec = $conexao->query($sql);
            }
            
            mysqli_close($conexao);
        }
        else{
            echo "<h4 class='error'> Erro: "
                . $conexao->connect_errno
                ."</h4>";
        }
    }

	// Obtem as horas disponiveis de um colaborador em um determinado dia
	function horasDisponiveis($dia, $empresa, $colaborador){
                                   
        $horas = array();
 
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = " SELECT hora 
                       FROM agendamento 
                      WHERE idempresa = $empresa
                        AND dia = '$dia'
						AND livre = 1
                        AND idcolaborador = $colaborador;";
 
            $exec = $conexao->query($sql); 
 
            $i = 1;
            while ( $f = $exec->fetch_object() )
            {
                $horas[$i]['nome'] = $f->hora;
                $i++;
            }
                            
            mysqli_close($conexao);
            return ($horas);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }
    }

	// Atualiza a agenda com a reserva do dia pelo cliente
    function agendarProcedimento($dia, $empresa, $colaborador, $procedimento, $hora, $cliente){
                                   
        $horas = array();
 
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = " UPDATE agendamento
						SET livre = false
							, idprocedimento=$procedimento
							, idcliente = $cliente
                      WHERE idempresa = $empresa
                        AND idcolaborador = $colaborador
                        AND dia = '$dia'
						AND hora = '$hora';";
 
            $exec = $conexao->query($sql); 
 
            //$i = 1;
            //while ( $f = $exec->fetch_object() )
            //{
            //    $horas[$i]['nome'] = $f->hora;
            //    $i++;
            //}
                            
            mysqli_close($conexao);
            //return ($horas);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }
    }
	
    //Busca todos os agendamentos de um determinado cliente
    function buscaAgendamentosCliente($cliente){
                                   
        $eventos = array();
 
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = "SELECT  ag.idagendamento
                            ,em.nomeempresa as empresa
                            ,cl.nomecolaborador as profissional
                            ,ag.dia as dia
                            ,ag.hora as hora
                            ,pr.nomeprocedimento as procedimento
                       FROM agendamento ag
                 INNER JOIN colaborador cl ON cl.idcolaborador = ag.idcolaborador 
                 INNER JOIN cliente ct ON ct.idcliente = ag.idcliente 
                 INNER JOIN procedimento pr ON pr.idprocedimento = ag.idprocedimento 
                 INNER JOIN empresa em ON em.idempresa = ag.idempresa 
                      WHERE ag.livre=false 
                        AND ag.idcliente=$cliente;";

            $exec = $conexao->query($sql); 
 
            $i = 1;
            while ( $f = $exec->fetch_object() )
            {
                $eventos[$i]['procedimento'] = $f->procedimento;
                $eventos[$i]['empresa'] = $f->empresa;
                $eventos[$i]['dia'] = $f->dia;
                $eventos[$i]['hora'] = $f->hora;
                
                $i++;
            }
                            
            mysqli_close($conexao);
            return ($eventos);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }        
    }

    //Relação de funções relativas a relatorios e graficos

    //Busca para uma data todos os procedimentos agendados para um profissional
    function relacaoProcedimentosAgendados($colaborador, $diaInicio, $diaFim, $empresa){
        $procedimentosAgendados = array();
 
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = "    SELECT agn.dia as dia
                               , agn.hora as hora
                               , agn.idcolaborador as idColaborador
                               , agn.idcliente as idCliente
                               , cli.nomecliente as nomeCliente
                               , agn.idprocedimento as idProcedimento
                               , prc.nomeprocedimento as nomeProcedimento
                               , prc.valorprocedimento as valorProcedimento
                          FROM agendamento agn
                    INNER JOIN procedimento prc on prc.idprocedimento = agn.idprocedimento
                    INNER JOIN cliente cli on cli.idcliente = agn.idcliente
                         WHERE agn.livre = 0
                           AND agn.idempresa = $empresa
                           AND agn.cancelado = 0
                           AND agn.idcolaborador = $colaborador
                           AND agn.dia BETWEEN '$diaInicio'  AND '$diaFim'
                      ORDER BY dia;";


            $exec = $conexao->query($sql); 
 
            $i = 1;
            while ( $f = $exec->fetch_object() )
            {
                $procedimentosAgendados[$i]['dia'] = $f->dia;
                $procedimentosAgendados[$i]['hora'] = $f->hora;
                $procedimentosAgendados[$i]['idColaborador'] = $f->idColaborador;
                $procedimentosAgendados[$i]['idCliente'] = $f->idCliente;
                $procedimentosAgendados[$i]['nomeCliente'] = $f->nomeCliente;
                $procedimentosAgendados[$i]['idProcedimento'] = $f->idProcedimento;
                $procedimentosAgendados[$i]['nomeProcedimento'] = $f->nomeProcedimento;
                $procedimentosAgendados[$i]['valorProcedimento'] = $f->valorProcedimento;
                $i++;
            }
                            
            mysqli_close($conexao);
            return ($procedimentosAgendados);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }    
    }

    //Relação de valores agendados por periodo para cada colaborador
    function relacaoValoresAgendados($diaInicio, $diaFim){
       $valoresAgendados = array();
 
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = " SELECT agn.idcolaborador as idColaborador
                            , col.nomecolaborador as nomeColaborador
                            , SUM(prc.valorprocedimento) as valor 
                       FROM agendamento agn
                 INNER JOIN procedimento prc on prc.idprocedimento = agn.idprocedimento
                 INNER JOIN colaborador col on col.idcolaborador = agn.idcolaborador
                      WHERE agn.livre = 0
                        AND agn.idempresa = 1
                        AND agn.cancelado = 0
                        AND agn.dia BETWEEN '$diaInicio' AND '$diaFim'
                   GROUP BY agn.idcolaborador
                   ORDER BY Valor DESC;";


            $exec = $conexao->query($sql); 
 
            $i = 1;
            while ( $f = $exec->fetch_object() )
            {
                $valoresAgendados[$i]['idColaborador'] = $f->idColaborador;
                $valoresAgendados[$i]['nomeColaborador'] = $f->nomeColaborador;
                $valoresAgendados[$i]['valor'] = $f->valor;
                $i++;
            }
                            
            mysqli_close($conexao);
            return ($valoresAgendados);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }    
        
    }

    //Relação de valores agendados por período por cada cliente
    function relacaoValoresAgendadosCliente($diaInicio, $diaFim){
    
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = "SELECT agn.idcliente as idCliente
                           , cli.nomecliente as nomeCliente
                           , SUM(prc.valorprocedimento) as valor 
                      FROM agendamento agn
                INNER JOIN procedimento prc on prc.idprocedimento = agn.idprocedimento
                INNER JOIN cliente cli on cli.idcliente = agn.idcliente
                     WHERE agn.livre = 0
                       AND agn.idempresa = 1
                       AND agn.cancelado = 0
                       AND agn.dia BETWEEN '$diaInicio' AND '$diaFim'
                  GROUP BY agn.idcliente
                  ORDER BY Valor DESC;";


            $exec = $conexao->query($sql); 
 
            $valoresAgendadosClientes = array();
 
            $i = 1;
            while ( $f = $exec->fetch_object() )
            {
                $valoresAgendadosClientes[$i]['idCliente'] = $f->idCliente;
                $valoresAgendadosClientes[$i]['nomeCliente'] = $f->nomeCliente;
                $valoresAgendadosClientes[$i]['valor'] = $f->valor;

                
                $i++;
            }
                            
            mysqli_close($conexao);
            return ($valoresAgendadosClientes);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }    
        
        
    }

    //Numeros de agendamento por clientes por periodo
    function numeroAgendamentoClientePeriodo($diaInicio, $diaFim){
      $numeroAgendamentoProcedimentoCliente = array();
 
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = " SELECT agn.idcliente as idCliente
		                    , cli.nomecliente as nomeCliente
                            , agn.idprocedimento as idProcedimento
                            , prc.nomeprocedimento as nomeProcedimento
                            , count(agn.idprocedimento) as numeroProcedimento
                       FROM agendamento agn
                 INNER JOIN cliente cli on cli.idcliente = agn.idcliente
                 INNER JOIN procedimento prc on prc.idprocedimento = agn.idprocedimento
                      WHERE agn.livre = 0
                        AND agn.idempresa = 1
                        AND agn.cancelado = 0
                        AND agn.dia BETWEEN '$diaInicio' AND '$diaFim'
                   GROUP BY agn.idcliente, agn.idprocedimento
                   ORDER BY agn.idcliente, agn.idprocedimento;";


            $exec = $conexao->query($sql); 
 
            $i = 1;
            while ( $f = $exec->fetch_object() )
            {
                $numeroAgendamentoProcedimentoCliente[$i]['idCliente'] = $f->idCliente;
                $numeroAgendamentoProcedimentoCliente[$i]['nomeCliente'] = $f->nomeCliente;
                $numeroAgendamentoProcedimentoCliente[$i]['idProcedimento'] = $f->idProcedimento;
                $numeroAgendamentoProcedimentoCliente[$i]['nomeProcedimento'] = $f->nomeProcedimento;
                $numeroAgendamentoProcedimentoCliente[$i]['numeroProcedimento'] = $f->numeroProcedimento;
                $i++;
            }
                            
            mysqli_close($conexao);
            return ($numeroAgendamentoProcedimentoCliente);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }    
 
    }

?>