<?php
    include BASE_DIR.'dao'.DS.'clienteDao.php';
    //include BASE_DIR.'lib'.DS.'funcoes.php';

//Cadastramento de novos usuários
class Registration
{

    private $db_connection = null;
    public $errors = array();
    public $messages = array();

    //construtor da classe
    public function __construct(){
        if (isset($_POST["register"])){
            $this->registerNewUser();
        }
    }

    private function registerNewUser(){
        //Valida se dados foram informados
        if (empty($_POST['userName'])) {
            $this->errors[] = "Favor informar um nome de usuário";
        }elseif (empty($_POST['userEmail'])) {
            $this->errors[] = "Favor informar um email";
        }elseif (empty($_POST['userPassword'])){
            $this->errors[] = "Favor informar a senha de acesso";
        } elseif (empty($_POST['userPasswordRepeat'])){
            $this->errors[] = "Favor informar a confirmação da senha";
        } 
        //Valida se dados estão conforme padrão    
        elseif ($_POST['userPassword'] !== $_POST['userPasswordRepeat']) {
            $this->errors[] = "A senha e sua confirmação precisam ser idênticas";
        } elseif (strlen($_POST['userPassword']) < 6) {
            $this->errors[] = "A Senha precisa ter no mínimo 6 caracteres";
        } elseif (strlen($_POST['userName']) > 64 || strlen($_POST['userName']) < 2) {
            $this->errors[] = "O Nome do usuário deve estar entre 2 e 64 caracteres";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['userName'])) {
            $this->errors[] = "O Nome de usuário deve conter apenas letras de a-Z e números";
        } elseif (strlen($_POST['userEmail']) > 64) {
            $this->errors[] = "O email não deve exceder 64 caracteres";
        } elseif (!filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "O Email informado não está em um formato válido";
        }
        //Se todos os dados foram informados de acordo com as regras então cadastra cliente no banco
        elseif (!empty($_POST['userName'])
            && strlen($_POST['userName']) <= 64
            && strlen($_POST['userName']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['userName'])
            && !empty($_POST['userEmail'])
            && strlen($_POST['userEmail']) <= 64
            && filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['userPassword'])
            && !empty($_POST['userPasswordRepeat'])
            && ($_POST['userPassword'] === $_POST['userPasswordRepeat'])
        ) {

                $user_name = $_POST['userName'];
                $user_email = $_POST['userEmail'];
                $user_password = encriptar($_POST['userPassword']);

                $possuiCadastro = validaCliente($user_email);
        
                if($possuiCadastro){
                    $this->errors[] = "Email já cadastrado na base.";
                }else{
                    $queryNewUserInsert = insereCliente($user_name, $user_password, $user_email);
                    
                    if ($queryNewUserInsert) {
                        $this->messages[] = "Sua conta foi criada com sucesso. Faça seu login.";
                    }else{
                      $this->errors[] = "Por favor reveja os dados informados e tente novamente";
                    }
                }
            //} else {
            //    $this->errors[] = "Não é possível se conectar ao banco. Por favor contate o Administrador";
            //}
        } else {
            $this->errors[] = "Favor contactar o administador informando o erro: 30055.";
        }
    }
}
