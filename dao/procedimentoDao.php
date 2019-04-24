<?php

// Lista de Procedimentos disponíveis numa data por empresa
    function procedimentosDisponiveisDataEmpresa($dia, $empresa){
                                
        $procedimentos = array();
    
        if(defined('DB_HOST')){
            $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        }
        else
        {
            require 'config.php';
            $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
            
        }
        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = "SELECT DISTINCT servico.idprocedimento AS idprocedimento
                                    , procedimento.nomeprocedimento AS nomeprocedimento
                               FROM servico 
                         INNER JOIN procedimento 
                                 ON procedimento.idprocedimento = servico.idprocedimento
                              WHERE idcolaborador IN (
                                                  SELECT DISTINCT idcolaborador 
                                                             FROM agendamento
                                                            WHERE idempresa = $empresa 
                                                              AND dia = '$dia');";
                      
            $exec = $conexao->query($sql); 
 
            $i = 1;
            while ( $f = $exec->fetch_object() )
            {
                $procedimentos[$i]['id'] = $f->idprocedimento;
                $procedimentos[$i]['nome'] = $f->nomeprocedimento;
                $i++;
            }
                            
            mysqli_close($conexao);
            return ($procedimentos);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }
    }
?>