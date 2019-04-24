
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Agenda Cliente</title>

        <links>
            <link rel="stylesheet" href="css/bootstrap.css"/>
            <link rel="stylesheet" href="css/jquery-ui.css">
			<link rel='stylesheet' href='css/fullcalendar.min.css'/>
            <link rel='stylesheet' href='css/calendario.css'/>
            <link rel="stylesheet" href="css/mine.css">
 			<link rel="stylesheet" href="css/principal.css"/>
			<link rel="stylesheet" href="css/radio_check_personalization.css"/>
       </links>
    </head>
    <body>
        <div class="container-fluid body_color">
            <div class="row" id="php">
                <?php
                    require 'config.php';
                    require BASE_DIR.'lib'. DS. 'Login.php';
                    require BASE_DIR.'lib'. DS. 'utils.php';
                    require BASE_DIR.'model'. DS. 'agenda.php';

                    $login = new Login();
                    $agenda = new agenda();
                
                    //Usuário só pode agendar se estiver logado 
                    if(!$login->isUserLoggedIn()) {
                        if (isset($login)) {
                            if ($login->errors) {
                                foreach ($login->errors as $error) {
                                    echo $error;
                                }
                            }
                            if ($login->messages) {
                                foreach ($login->messages as $message) {
                                    echo $message;
                                }
                            }
                        }
                        header('Location: index.php');           
                    } 

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
                                    die('Não foi possível criar pasta');
                                }
                            }

                            $eventos = $agenda->buscaAgendamentosCliente($_SESSION['userId']);
                            criaEventosCliente($eventos);
                        ?>
                    </div>
					<div id='script-warning'>
                        <code>php/get-events.php</code> must be running.
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


<!--


   			<div class="row" id="linha_menu">
                <div class="col-sm-12">
				    <nav class="navbar navbar-default navbar-fixed-top">
					<div class="container-fluid">
    					<div class="navbar-header">
    						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        						<span class="icon-bar"></span>
        						<span class="icon-bar"></span>
        						<span class="icon-bar"></span> 
      						</button>		
      						<a class="navbar-brand" href="#">AGENDARE</a>
 	   					</div>
 	   					<div class="collapse navbar-collapse" id="myNavbar">
   							<ul class="nav navbar-nav">
      							<li><a href="agendacliente.php">Minha Agenda</a></li>
    						</ul>
                            
                            <form class="navbar-form navbar-right" method="post" action="index.php">
                                <div class="form-group">
                                    <span id="loginIcone" class="glyphicon glyphicon-user"></span>
                                    
                                    <input type="text" id="userEmail" name="userEmail" class="form-control form-control-navbar" placeholder="login">
                                    
                                    <input type="password" id="userPassword" name="userPassword" class="form-control form-control-navbar" placeholder="senha">
    	  					    </div>
                                
                                <button type="submit" 
                                        name="login" 
                                        id="login" 
                                        class="btn btn-default form-button-navbar"> 
                                    <span class="glyphicon glyphicon-log-in"></span>
                				</button>
    				        </form>
        				</div>
  					</div>
				</nav>
                </div>
            </div>



-->