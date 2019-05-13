<?php
  session_start();
  error_reporting(E_ALL|E_STRICT);

  require '../config.php';
  require BASE_DIR.'lib'.DS.'utils.php';
  require BASE_DIR.'model'.DS.'pessoa.php';

  $pessoa = new pessoa();

  $logado = $pessoa->usuarioLogado();

  //verifica se usuário ja se encontra logado
  if($logado['sucesso']){
    echo "<script type='text/javascript'>window.location='../index.php; </script>";
  }
  else{
    //Se nao esta logado tenta o login do usuário
    $retorno = null;

    //Verifica se há cookie armazenado
    if (isset($_COOKIE['userEmail']) && isset($_COOKIE['userPassword'])){
      //caso haja, tenta-se o login do usuário
      $pessoa->emailPessoa = (isset($_COOKIE['userEmail'])?$_COOKIE['userEmail']:null);
      $pessoa->senhaPessoa = (isset($_COOKIE['userPassword'])?$_COOKIE['userPassword']:null);
      $retorno = $pessoa->fazerLogin(false);
    }
    elseif(isset($_POST['userEmail']) && isset($_POST['userPassword'])){
      //Se não houver cookie tenta acesso com dados informados
      $pessoa->emailPessoa = (isset($_POST['userEmail'])?$_POST['userEmail']:null);
      $pessoa->senhaPessoa = (isset($_POST['userPassword'])?$_POST['userPassword']:null);

      //Caso nao haja cookie verifica se é apra armazenar
      if(isset($_POST['rememberme']))
        $pessoa->fazerLogin(true);
      else
        $retorno = $pessoa->fazerLogin(false);
      }

      if($retorno["sucesso"]){
        echo "<script type='text/javascript'>window.location='../index.php'; </script>";
      }
      else {

        echo "<script type='text/javascript'>window.location='../login.php?message=".$retorno["mensagem"]."'; </script>";
      }
  }
?>
