<?php

    class conexao{

        public function obterConexao(){
        
            $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

            if (!$conexao->set_charset("utf8")) {
                echo $conexao->error;
            }
            
            //Se a conexão com o banco for bem sucedida
            if (!$conexao->connect_errno) {

                return $conexao;
            }
            else{
                return $conexao->connect_errno;
            }
        }
    }
?> 

