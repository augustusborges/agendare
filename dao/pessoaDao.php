<?php

    require_once BASE_DIR.'dao'.DS.'conexao.php';

    class pessoaDao{
       
        //Insere um novo usuário no sistema
        public function inserePessoa($pessoa){
        
            //Abre conexao com banco de dados
            $conn = new conexao();
            $conexao = $conn->obterConexao();
            $sucesso = false;
            
               
            //Se não houver email identico ao informado na base de dados
            if(is_null($this->validaPessoa($pessoa->emailPessoa))){

                //cadastra a pessoa na base de dados
                $sql = "INSERT INTO pessoa 
                        (nomepessoa, senhapessoa, tipopessoa, emailpessoa)
                        VALUES('" 
                        .$pessoa->nomePessoa 
                        ."', '" 
                        .$pessoa->senhaPessoa 
                        ."', " 
                        .$pessoa->tipoPessoa 
                        .", '" 
                        .$pessoa->emailPessoa
                        ."');";

                $exec = $conexao->query($sql);

                if($exec)
                    $sucesso = true;
        
                mysqli_close($conexao);
            }
            else{
                //Tratamento de Mensagens do sistema
            }
            return $sucesso;
        }

        //Verifica se já existe email igual ao informado cadastrado no sistema
        //Retorna objeto pessoa caso exista e false caso não exista
        public function validaPessoa($email){
            
            $conn = new conexao();
            $conexao = $conn->obterConexao();
            $PessoaCadastrada = new pessoa();
              
            $sql = "SELECT idpessoa
                           , nomepessoa
                           , emailpessoa
                           , senhapessoa
                           , tipopessoa 
                      FROM pessoa 
                     WHERE emailpessoa = '" . $email . "';";

            $exec = $conexao->query($sql);

            if ( $f = $exec->fetch_object() ){
                $PessoaCadastrada->idPessoa = $f->idpessoa;
                $PessoaCadastrada->nomePessoa = $f->nomepessoa;
                $PessoaCadastrada->emailPessoa = $f->emailpessoa;
                $PessoaCadastrada->senhaPessoa = $f->senhapessoa;
                $PessoaCadastrada->tipoPessoa = $f->tipopessoa;
            }else{
                $PessoaCadastrada = null;        
            }
            
            mysqli_close($conexao);
        
            return $PessoaCadastrada;
        }

    }
    
?>