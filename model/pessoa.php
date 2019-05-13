<?php
  session_start();
  error_reporting(E_ALL|E_STRICT);

  require_once BASE_DIR."dao".DS."pessoaDao.php";

    class pessoa{

        public $idPessoa;
        public $nomePessoa;
        public $senhaPessoa;
        public $emailPessoa;
        public $tipoPessoa;

        public function __Construct(){}

        //Insere novo usuário do sistema (Cliente ou Colaborador)
        public function inserePessoa($pessoa){
            $pessoadao = new pessoaDao();
            $insere = $pessoadao->inserePessoa($pessoa);
        }

        //Realiza o login do usuário com dados informados por form e cria sua sessão
        private function fazerLoginComForm(){

            //Cria objeto para cliente logado
            include("model/cliente.php");
            $cliente = new cliente();

            //valida se usuario foi informado
            if (empty($_POST['userEmail'])) {
                $this->errors[] = "Favor informar email cadastrado";
            }
            //valida se senha foi informada
            elseif (empty($_POST['userPassword'])) {
                $this->errors[] = "Favor informar a senha";
            }
            //Se usuário e senha informados
            elseif (!empty($_POST['userEmail']) && !empty($_POST['userPassword'])) {

                    //Monta o objeto cliente a partir do email informado
                    $Cliente = $cliente->validaCliente($_POST['userEmail']);

                    //Valida se usuário foi encontrado no banco de dados
                    if($Cliente->idCliente != 0){

                        //Valida se senha informada confere com senha cadastrada
                        if (password_verify($_POST['userPassword'], $Cliente->senhaCliente)) {

                            //Monta a sessão do usuário
                            session_start();
                            $_SESSION['sessionId'] = session_id();
                            $_SESSION['pessoaId'] = $Pessoa->idCliente;
                            $_SESSION['pessoaNome'] = $Cliente->nomeCliente;
                            $_SESSION['pessoaEmail'] = $Cliente->emailCliente;
                            $_SESSION['pessoaSenha'] = $Cliente->senhaCliente;
                            $_SESSION['pessoaTipo'] = $Cliente->tipoCliente;

                            if(isset($_POST['rememberme'])){

                                // Cria  cookie para login automatico
                                setcookie('userEmail', $_POST['userEmail'], time()+120);//, time()+60*60*24*365
                                setcookie('userPassword', $_POST['userPassword'], time()+120);

                            }
                        }
                        else {
                            $this->errors[] = "Senha inválida para usuário informado.";
                        }
                    }
                    else {
                            $this->errors[] = "O email informado não consta na nossa base.";
                    }
            }
            else {
                    $this->errors[] = "Email ou Senha não foram devidamente informados. Favor revisar.";
            }
        }

        //Realiza o login do usuário e cria sua sessão
        public function fazerLogin($geraCookie){

            $PessoaDao = new pessoaDao();
            $retorno = array();
            $retorno['sucesso'] = false;
            $retorno['mensagem']= "";

            //Se email e senha foram informados
            if(isset($this->emailPessoa) && isset($this->senhaPessoa)){

                    //Busca os dados do usuário a se logar
                    $dadosCadastrados = $PessoaDao->validaPessoa($this->emailPessoa);

                    if($dadosCadastrados->emailPessoa == $this->emailPessoa){

                        $senha = $dadosCadastrados->senhaPessoa;
                        if(password_verify($this->senhaPessoa, $senha)){
                            $_SESSION['sessionId'] = session_create_id('daab-');
                            $_SESSION['userId'] = $dadosCadastrados->idPessoa;
                            $_SESSION['userName'] = $dadosCadastrados->nomePessoa;
                            $_SESSION['userEmail'] = $dadosCadastrados->emailPessoa;
                            $_SESSION['userPassword'] = $dadosCadastrados->senhaPessoa;
                            $_SESSION['userType'] = $dadosCadastrados->tipoPessoa;

                            //Cria  cookie para login automatico
                            if($geraCookie){
                                setcookie('userEmail', $_POST['userEmail'], time()+600);//+60*60*24*365
                                setcookie('userPassword', $_POST['userPassword'], time()+600);
                            }
                            $retorno['sucesso'] = true;
                            $retorno['mensagem'] = "Login realizado com sucesso!";
                        }
                        else{
                            $retorno['mensagem'] = "Senha informada não coincide com senha cadastrada para email informado";
                            return $retorno;
                        }

                        return $retorno;
                    }
                    else{
                      $retorno['mensagem'] = "Email informado não existe na base de dados!";
                      return $retorno;
                    
                }
                return $retorno;
            }
            else{
                $retorno['mensagem']= "É obrigatório informar email e senha válidos";
                return $retorno;
            }
        }

        //Executa logout do usuário
        public function fazerLogout(){

          if(isset($_SESSION['sessionId'])){
            session_destroy();
          }

          else{
            //TODO retornar
          }
        }

        //Retorna se o cliente esta logado: True ou False
        public function usuarioLogado(){

          $retorno = array();
          $retorno['sucesso'] = false;
          $retorno['mensagem']= "";

          if (isset($_SESSION['sessionId'])) {
            $retorno['sucesso'] = true;
            $retorno['mensagem']= "Usuário já se encontra logado!";
          }
          else{
            $retorno['sucesso'] = False;
            $retorno['mensagem']= "Usuário não se encontra logado!";
          }

          return $retorno;
        }

        //Insere o registro de acesso de usuário na base
        public function inserirDadosLogin(){

            $this->conexao = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

            //Se a conexão com o banco for bem sucedida
            if (!$this->conexao->connect_errno) {

                $usuario = $_SESSION['user_id'];

                setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );
                date_default_timezone_set( 'America/Sao_Paulo' );
                $dia = strftime( '%Y-%m-%d %H:%M:%S', strtotime('now'));

                $sql = "Insert Into controle_acesso (usuario, data)
                        values ('$usuario', '$dia')";

                $result_of_login_check = $this->conexao->query($sql);

                mysqli_close($this->conexao);
            }
        }
    }

?>
