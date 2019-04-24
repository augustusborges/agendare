<?php
    // gerencia o processo de login e logout de usuários
    class Login{
    
    public $errors = array();
    public $messages = array();

    public function __construct(){
        if(isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }

    //Executa o login do usuário e cria sua sessão
    private function dologinWithPostData(){

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
                        $_SESSION['userId'] = $Cliente->idCliente;
                        $_SESSION['userName'] = $Cliente->nomeCliente;
                        $_SESSION['userEmail'] = $Cliente->emailCliente;
                        $_SESSION['userPassword'] = $Cliente->senhaCliente;

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

    //Executa o login do usuário e cria sua sessão
    public function doLogin($userEmail, $userPassword){

        //Cria objeto apra cliente logado
        include("model/cliente.php");
        $cliente = new cliente();

        //valida se usuario foi informado
        if (empty($userEmail)) {
            $this->errors[] = "Favor informar email cadastrado";
        } 
        //valida se senha foi informada
        elseif (empty($userPassword)) {
            $this->errors[] = "Favor informar a senha";
        } 
        //Se usuário e senha informados
        elseif (!empty($userEmail) && !empty($userPassword)) {

                //Monta o objeto cliente a partir do email informado
                $Cliente = $cliente->validaCliente($userEmail);
            
                //Valida se usuário foi encontrado no banco de dados
                if($Cliente->idCliente != 0){
            
                    //Valida se senha informada confere com senha cadastrada
                    if (password_verify($userPassword, $Cliente->senhaCliente)) {

                        //Monta a sessão do usuário
                        //session_start();
                        $_SESSION['sessionId'] = session_id();
                        $_SESSION['userId'] = $Cliente->idCliente;
                        $_SESSION['userName'] = $Cliente->nomeCliente;
                        $_SESSION['userEmail'] = $Cliente->emailCliente;
                        $_SESSION['userPassword'] = $Cliente->senhaCliente;
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

    //Executa logout do usuário
    public function doLogout(){

        session_start();
        if(isset($_SESSION['sessionId'])){
            echo "Usuario ". $_SESSION['sessionId']. " - " .$_SESSION['userName']. " deslogado! <br/>";
            session_destroy();
        }
    }

    //Retorna se o cliente esta logado: True ou False
    public function isUserLoggedIn(){

       // @ session_start();
        
        if(!isset($_SESSION))
        {
            session_start();
        }
        
        if (isset($_SESSION['sessionId'])) {
            return true;
        }

        return false;
    }

    //Insere o registro de acesso de usuário na base
    public function insertLogginData(){
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
