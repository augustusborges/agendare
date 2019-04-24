<?php

    //Valida se o email já está cadastrado na base de dados retornando true caso haja cadastro
    function validaCliente($email){
        
        //Abre conexao com banco de dados
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        $possuiCadastro = false;
        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {


                $sql = "SELECT * 
                          FROM cliente 
                         WHERE emailcliente = '" . $email . "';";
            
                $exec = $conexao->query($sql);

            if ( $f = $exec->fetch_object() )
            {
                $possuiCadastro = true;
            }
            
            mysqli_close($conexao);
        }
        else{
            echo "<h4 class='error'> Erro: "
                . $conexao->connect_errno
                ."</h4>";
        }
        
        return $possuiCadastro;

    }

    //Insere um novo cliente no sistema
    function insereCliente($nome, $senha, $email){
        

        
        //Abre conexao com banco de dados
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        $sucesso = false;

        //remove codigo html ou javascript
        //$nome = $this->conexao->real_scape_string(strip_tags($nome, ENT_QUOTES));
        //$senha = $this->conexao->real_scape_string(strip_tags($senha, ENT_QUOTES));
        //$email = $this->conexao->real_scape_string(strip_tags($email, ENT_QUOTES));
        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {

            $sql = "INSERT INTO cliente 
                                (nomecliente, senhacliente, emailcliente)
                         VALUES('" 
                                .$nome 
                                ."', '" 
                                .$senha 
                                ."', '" 
                                .$email
                                ."');";
            
            $exec = $conexao->query($sql);

            if($exec)
                $sucesso = true;
            
            mysqli_close($conexao);
        }
        else{
            echo "<h4 class='error'> Erro: "
                . $conexao->connect_errno
                ."</h4>";
        }
        return $sucesso;
    }

    //Monta um objeto cliente a partir do email do cliente
    function obtemCliente($email){
              
        //Abre conexao com banco de dados
        $cliente = new cliente();
        $conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        
        if (!$conexao->set_charset("utf8")) {
            echo $conexao->error;
        }
            
        //Se a conexão com o banco for bem sucedida
        if (!$conexao->connect_errno) {


                $sql = "SELECT idcliente, nomecliente, emailcliente, senhacliente 
                          FROM cliente 
                         WHERE emailcliente = '" . $email . "';";
            
                $exec = $conexao->query($sql);

            
            if ( $f = $exec->fetch_object() )
            {
                $cliente->idCliente = $f->idcliente;
                $cliente->nomeCliente = $f->nomecliente;
                $cliente->emailCliente = $f->emailcliente;
                $cliente->senhaCliente = $f->senhacliente;
            }
            
            mysqli_close($conexao);
        }
        else{
            echo "<h4 class='error'> Erro: "
                . $conexao->connect_errno
                ."</h4>";
        }
        

        return $cliente;


    }

?>