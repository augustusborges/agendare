<?php
  session_start();
  error_reporting(E_ALL|E_STRICT);
  require_once 'config.php';
  require_once BASE_DIR.'lib'.DS.'utils.php';
  require_once BASE_DIR.'model'.DS.'pessoa.php';

  //Validação de usuário logado
  $pessoa = new pessoa();
  if(($pessoa->usuarioLogado())['sucesso'] == false){
    echo "<script type='text/javascript'>window.location='index.php'; </script>";
  }
  else {
    consoleLog($_SESSION['userName']);
  }

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Monta agenda de marcação de clientes">
    <meta name="keywords" content="agendamento, sistema, arcação online, Sites, Desenvolvimento"/>
    <meta name="author" content="Focus4 Business Intelligence Ltda"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Agenda do Cliente</title>

    <links>
      <link rel="stylesheet" href="css/bootstrap.css"/>
      <link rel="stylesheet" href="css/jquery-ui.css">
		  <link rel='stylesheet' href='css/fullcalendar.min.css'/>
      <link rel='stylesheet' href='css/calendario.css'/>
      <link rel="stylesheet" href="css/mine.css">
 		  <link rel="stylesheet" href="css/principal.css"/>
    </links>
  </head>
  <body>
    <div class="container-fluid body_color">

      <div class="row" id="php">
        <?php
          include BASE_DIR.'model'. DS. 'agenda.php';
          $agenda = new agenda();
        ?>
      </div>

      <div class="row" id="menu">
        <?php include BASE_DIR.'view'.DS.'_menu.php';?>
      </div>

      <div class="row" id="cabecalho">
        <div class="col-sm-12">
          <header>
            <div class="cabecalho-borda cabecalho-texto">Agenda do Cliente</div>
					</header>
        </div>
			</div>

      <div class="row" id="corpo">
        <div class="col-sm-12">
          <?php
              $empresa = (isset($_POST['empresa'])?$_POST['empresa']:0);
              $dia = (isset($_POST['dt_agenda'])?$_POST['dt_agenda']:"");
              $procedimento = (isset($_POST['procediments'])?$_POST['procediments']:"");
              $profissional = (isset($_POST['profissionais'])?$_POST['profissionais']:"");
              $hora = (isset($_POST['horaAgendada'])?$_POST['horaAgendada']:"");
              $cliente = $_SESSION['userId'];

              if($profissional != ""){
                  if($hora != ""){
                      $ddia = date('Y/m/d',strtotime(converteData($dia)));
                      $agenda->agendarProcedimento($ddia, $empresa, $profissional, $procedimento, $hora, $cliente);
                  }
              }
          ?>
				</div>
			</div>

      <div class="row" id="calendario">
        <div class="col-sm-12">
            <div id="montaCalendario">
            <?php
              $caminho = BASE_DIR.'diretorio'.DS.$_SESSION['sessionId'];

              if(!file_exists($caminho)) {
                if(!mkdir($caminho)){
                  die();
                }
              }

              $eventos = $agenda->buscaAgendamentosCliente($_SESSION['userId']);
              criaEventosCliente($eventos); // /lib/utils
            ?>
          </div>

            <div id='script-warning'>
            <code>lib/criaragenda.php</code>precisa estar rodando. Favor avisar ao administrador!
          </div>
	          <div id="clndAgendaCliente"></div>
				</div>
			</div>

			<div class="row" id="rodape">
				<div class="col-sm-12">
					<footer></footer>
				</div>
			</div>

      <section id="scripts">
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/external/jquery/jquery.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/jquery-ui-add.js"></script>
				<script src='js/moment.min.js'></script>
        <script src='js/fullcalendar.min.js'></script>
        <script src='js/locale/pt-br.js'></script>
        <script src='js/calendar-ui-add.js'></script>
      </section>
    </div>
  </body>
</html>
