<?php


    // Lista de colaboradores de uma determinada empresa
    function listaEmpresa(){
                                
        $empresas = array();
 
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
                        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {
            $sql = "SELECT idempresa, nomeempresa
                      FROM empresa";
                      
            $exec = $conexao->query($sql); 
 
            $i = 1;
            while ( $f = $exec->fetch_object() )
            {
                $empresas[$i]['id'] = $f->idempresa;
                $empresas[$i]['nome'] = $f->nomeempresa;
                $i++;
            }
                            
            mysqli_close($conexao);
            return ($empresas);

        }
        else{
            echo "<h4 class='error'> Erro: ". $conexao->connect_errno."</h4>";
        }
    }
?>