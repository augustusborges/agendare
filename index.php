<?php
  session_start();
  error_reporting(E_ALL|E_STRICT);
  require_once 'config.php';
  require_once BASE_DIR.'lib'.DS.'utils.php';
  require_once BASE_DIR.'model'.DS.'pessoa.php';

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <meta name="author" content="Focus4 Business Intelligence Ltda"/>
    <meta name="description" content="Aplicativo de agendamento de processos online"/>
    <meta name="keywords" content="sistemas, agenda, agendamento, online"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <title>Agendare - Seu Procedimento a um click </title>

    <links>
      <link rel="stylesheet" href="css/bootstrap.css"/>
      <link rel="stylesheet" href="css/jquery-ui.css"/>
      <link rel="stylesheet" href="css/mine.css"/>
      <link rel="stylesheet" href="css/principal.css"/>
      <link rel="stylesheet" href="css/radio_check_personalization.css"/>
    </links>
  </head>
  <body>
    <div class="container-fluid body_color">

      <div class="row" id="php">
        <?php
          require BASE_DIR.'model'.DS.'empresa.php';

          $pessoa = new pessoa();
          $empresa = new empresa();

          //Se usuário não logado
          if(!$pessoa->usuarioLogado()) {

            //Verifica se há cookie armazenado
            if (isset($_COOKIE['userEmail']) && isset($_COOKIE['userPassword'])){

              //caso haja, tenta-se o login do usuário
              $pessoa->emailPessoa = (isset($_COOKIE['userEmail'])?$_COOKIE['userEmail']:null);
              $pessoa->senhaPessoa = (isset($_COOKIE['userPassword'])?$_COOKIE['userPassword']:null);
              $pessoa->fazerLogin(false);

            }
            elseif(isset($_POST['userEmail']) && isset($_POST['userPassword'])){

              $pessoa->emailPessoa = (isset($_POST['userEmail'])?$_POST['userEmail']:null);
              $pessoa->senhaPessoa = (isset($_POST['userPassword'])?$_POST['userPassword']:null);

              if(isset($_POST['rememberme'])){
               $pessoa->fazerLogin(true);
              }
              else{
               $pessoa->fazerLogin(false);
              }
              //TODO: Inserir mensagens de login
            }
          }
          else{
            //TODO: Inserir Mensagem de Logado
          }
        ?>
      </div>

      <div class="row" id="menu">
        <?php include BASE_DIR.'view'.DS.'_menu.php';?>
        <div></div>
      </div>

      <div class="row" id="cabecalho">
        <div class="col-sm-12">
          <header>
            <div id="cabecalho" name="cabecalho" class="cabecalho-borda cabecalho-texto">
              Agende Seu Procedimento
            </div>
          </header>
        </div>
      </div>

      <div class="row" id="formulario">
        <div class="col-sm-12">
          <div class="form-borda-padrao">
            <section id="formulario">
              <form name="agendamento" action="agendacliente.php" method="post">
                <!-- Lista de empresas-->
                <div class="divForm">
                  <label class="form-label">Empresa:</label>
                  <?php
                  $listaEmpresas = $empresa->getListaEmpresas();

                  //Monta lista de empresas
                  echo "<select id='empresa'
                  name='empresa'
                  class=\"form-component\">";
                  echo "<option>Selecione</option>";

                  $count = count($listaEmpresas);
                  for($i=1; $i <= $count; $i++)
                  echo "<option value=".$listaEmpresas[$i]['id'].">".$listaEmpresas[$i]['nome']."</option>";
                  echo "</select>";
                  ?>
                </div>

                <!-- Data de agendamento-->
                <div class="divForm">
                  <label class="form-label">Data:</label>
                  <?php
                  echo "<input type=\"text\"
                  name=\"dt_agenda\"
                  id=\"dt_agenda\"
                  placeholder=\"Selecione\"
                  class=\"form-component\" onchange=\"getProcedimentos();\" autocomplete=\"off\">";
                  ?>
                </div>

                <!-- Lista de procedimentos-->
                <div class="divForm">
                  <!--Recebe a lista de procedimentos por ajax-->
                  <div id="listaProcedimentos"></div>
                </div>

                <!-- Lista de profissionais-->
                <div class="divForm">
                  <!--Recebe a lista de profissionais disponivel por ajax-->
                  <div id="listaProfissionais"></div>
                </div>

                <!-- Horas de trabalho-->
                <div class="divForm">
                  <!--Recebe a lista de profissionais disponivel por ajax--><div id="listaHoras"></div>
                </div>

                <!-- Verificação usuário Logado-->
                <div id="usuarioLogado">
                  <?php
                  //campo para verificação de usuário logado.
                  //Se não logado não pode agendar procedimentos
                  if(isset($_SESSION["sessionId"])){
                    echo "<input type='hidden'
                    id='sessao'
                    value='5000'>";
                  }
                  else{
                    echo "<input type='hidden'
                    id='sessao'
                    value='1000'>";
                  }
                  ?>
                </div>

                <input type="submit" value="Agendar" id="agendar"
                onclick="valida_sessao(sessao); return false;">
              </form>
            </section>
          </div>
        </div>
      </div>

      <div class="row" id="rodape">
      </div>
    
    </div>

    <section id="scripts">
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/jquery-ui.min.js"></script>
      <script src="js/jquery-ui-add.js"></script>
      <script src="js/ajax.js"></script>
      <script src="js/principal.js"></script>
      <script src='js/moment.min.js'></script>
      <script src='js/fullcalendar.min.js'></script>
      <script src='js/locale/pt-br.js'></script>
      <script src='js/calendar-ui-add.js'></script>
    </section>

  </body>
</html>


<!--
          <?php

            //Validação de usuário logado no sistema
            //com mensagem de boas vindas.
            // if($pessoa->usuarioLogado()){
            //
            //   echo "<a href=\"#\"
            //   title=\"Bem vindo, "
            //   . $_SESSION['userName']
            //   . "!\"
            //   >
            //
            //   <span id=\"loginIcone\"
            //   class=\"glyphicon
            //   glyphicon-user
            //   icone-color-navbar-ok
            //   \"
            //   ></span></a>";
            // }
            // else{
            //   echo "<a href=\"#\"
            //   title=\"Olá, você precisa estar logado
            //   para acessar o sistema!\"
            //   >
            //
            //   <span id=\"loginIcone\"
            //   class=\"glyphicon
            //   glyphicon-user
            //   icone-color-navbar-nok
            //   \"
            //   ></span></a>";
            //}
          ?>



      </div>
    </div>







  </nav>
</div>


-->
