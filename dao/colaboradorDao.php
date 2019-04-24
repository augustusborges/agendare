<?php

    //Lista de colaboradores de uma determinada empresa
    function listaColaborador($idEmpresa){
                                
        $colaboradores = array();
 
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = "SELECT idcolaborador, nomecolaborador
                      FROM colaborador
                     WHERE idempresa = $idEmpresa";
 
            $exec = $conexao->query($sql); 
 
            $i = 1;
            while ( $f = $exec->fetch_object() )
            {
                $colaboradores[$i]['id'] = $f->idcolaborador;
                $colaboradores[$i]['nome'] = $f->nomecolaborador;
                $i++;
            }
                            
            mysqli_close($conexao);
            return ($colaboradores);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }
    }

    //Todo colaborador que disponivel em determinada data exerce um procedimento especifico
    function colaboradorProcedimentoData($empresa, $procedimento, $dia){
                                
        $colaboradores = array();
 
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = "SELECT DISTINCT servico.idcolaborador as idcolaborador
                                    , colaborador.nomecolaborador as nomecolaborador
                               FROM servico 
                         INNER JOIN colaborador 
                                 ON colaborador.idcolaborador = servico.idcolaborador
                              WHERE servico.idprocedimento = $procedimento
                                AND colaborador.idcolaborador IN (
							                     SELECT DISTINCT idcolaborador 
                                                            FROM agendamento
									                       WHERE idempresa = $empresa 
										                     AND dia = '$dia');";
 
            $exec = $conexao->query($sql); 
 
            $i = 1;
            while ( $f = $exec->fetch_object() )
            {
                $colaboradores[$i]['id'] = $f->idcolaborador;
                $colaboradores[$i]['nome'] = $f->nomecolaborador;
                $i++;
            }
                            
            mysqli_close($conexao);
            return ($colaboradores);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }
    }

	//Documentar
    function  profissionaisDisponiveisProcedimentoDataEmpresa($dia, $empresa, $procedimento){
                                
        $colaboradores = array();
 
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = "SELECT DISTINCT servico.idcolaborador as idcolaborador
                                    , colaborador.nomecolaborador as nomecolaborador
                               FROM servico 
                         INNER JOIN colaborador 
                                 ON colaborador.idcolaborador = servico.idcolaborador
                              WHERE servico.idprocedimento = $procedimento
                                AND colaborador.idcolaborador IN (
							                     SELECT DISTINCT idcolaborador 
                                                            FROM agendamento
									                       WHERE idempresa = $empresa 
										                     AND dia = '$dia');";
 
            $exec = $conexao->query($sql); 
 
            $i = 1;
            while ( $f = $exec->fetch_object() )
            {
                $colaboradores[$i]['id'] = $f->idcolaborador;
                $colaboradores[$i]['nome'] = $f->nomecolaborador;
                $i++;
            }
                            
            mysqli_close($conexao);
            return ($colaboradores);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }
    }

	//Busca a lista de dias que um determinado colaborador tem horário disponível
    function obtemDiasTrabalhoColaborador($colaborador){
        
                                        
        $diasTrabalho = array();
 
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = "SELECT Distinct dia
                      FROM agendamento
                     WHERE idcolaborador = $colaborador
                       AND livre = 1";
 
            $exec = $conexao->query($sql); 
 
            $i = 1;
            while ( $f = $exec->fetch_object() )
            {
                $diasTrabalho[$i]['dia'] = $f->dia;
                $i++;
            }
                            
            mysqli_close($conexao);
            return ($diasTrabalho);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }
    }
?>