<?php
    require BASE_DIR.'model'.DS.'pessoa.php';

    $Pessoa = new pessoa();

    //Verifica se usuário não está logado
    if(!$Pessoa->usuariologado()) {

        //Se não tiver verifica se tem cookie armazenado
        if (isset($_COOKIE['userEmail']) && isset($_COOKIE['userPassword'])){

            //Se tiver cookie tenta login
            $Pessoa->pessoaEmail = $_COOKIE['userEmail'];
            $Pessoa->pessoaSenha = $_COOKIE['userPassword'];
            $Pessoa->fazerLogin();
            
            //Se login bem sucedido apresenta dados de login
            //Se login mal sucedido apresenta formulario de login e mensagem de deslogado
        }//Se não possui coockie
        else{
            
        }
    }//se o usuário já estiver logado
    else{
        //apresenta dados de login
    }
?>