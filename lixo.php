<?php
    require 'config.php';
    require BASE_DIR."lib".DS."Login.php";
    require BASE_DIR."lib".DS.'utils.php';
    require BASE_DIR."model".DS."pessoa.php";
    require BASE_DIR."model".DS.'empresa.php';

    $login = new Login();
    $empresa = new empresa();

    //Se usuário não logado
    if(!$login->isUserLoggedIn()) {
        echo "nao esta logado <br/>";
        //Verifica se há cookie armazenado
        if (isset($_COOKIE['userEmail']) && isset($_COOKIE['userPassword'])){

            echo "Valida Cookie:".$_COOKIE['userEmail'] ." + ". $_COOKIE['userPassword'];
            //Tendo tenta-se o login do usuário
            $login->doLogin($_COOKIE['userEmail'], $_COOKIE['userPassword']);

            echo "logado pelo cookie.<br/>";

        } 
        //exibe as mensagens de login
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
    }  
    else{
        echo "Usuario logado: ".$_COOKIE['userEmail'] ." + ". $_COOKIE['userPassword'];
    }  
?>
<!DOCTYPE html>
<html>
    <!--AGENDAMENTO-->
    <head>
        <meta charset="utf-8"/>
        <meta name="description" content=""/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>

        <title>daab - Agendamento</title>

        <links>
            <link rel="stylesheet" href="css/bootstrap.css"/>
            <link rel="stylesheet" href="css/jquery-ui.css"/>
            <link rel="stylesheet" href="css/jquery-ui.theme.min.css"/>
            <link rel="stylesheet" href="css/mine.css"/>
			<link rel="stylesheet" href="css/principal.css"/>
			<link rel="stylesheet" href="css/radio_check_personalization.css"/>
        </links>
    </head>
    <body>
        <div class="container-fluid body_color">
            <div class="row" id="menu">
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
                                    <li><a href="graficos.php">Graficos</a></li>
                                </ul>
                               
                                <form class="navbar-form navbar-right" 
                                      method="post" 
                                      action="index.php">

                                    <?php 
                                        //Validação de usuário logado no sistema
                                        //com mensagem de boas vindas.
                                        if($login->isUserLoggedIn()){
                                                
                                            echo "<a href=\"#\" 
                                                     title=\"Bem vindo, "
                                                     . $_SESSION['userName']
                                                     . "!\"
                                                  >
                                                    
                                                    <span id=\"loginIcone\" 
                                                                class=\"glyphicon  
                                                                        glyphicon-user
                                                                        icone-color-navbar-ok
                                                                        \"
                                                        ></span></a>";
                                            }
                                        else{
                                            echo "<a href=\"#\" 
                                                     title=\"Olá, você precisa estar logado
                                                            para acessar o sistema!\"
                                                  >
                                                    
                                                    <span id=\"loginIcone\" 
                                                                class=\"glyphicon  
                                                                        glyphicon-user
                                                                        icone-color-navbar-nok
                                                                        \"
                                                        ></span></a>";
                                            }
                                    ?>

                                    <div class="form-group">
                                        
                                        <input type="text" id="userEmail" name="userEmail" class="form-control form-control-navbar" placeholder="login">
    	    				
                                        <input type="password" id="userPassword" name="userPassword" class="form-control form-control-navbar" placeholder="senha">

                                        <button type="submit" name="login" class="btn btn-default">
                                            <span class="glyphicon glyphicon-log-in"></span>
                                        </button>
                                        
                                        <br/>

                                        <div id="rememberme" class="remember">
                                            <input type="checkbox" name="rememberme" class="remember" value="1">
                                        
                                            <label for="rememberme" class="remember-label">
                                                Manter-me Logado:
                                            </label>
                                        </div>
                                        
        
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                                                    
                            
                            

                            
                            

				</nav>
                </div>
            </div>
			<div class="row" id="cabecalho">
				<div class="col-sm-12">
					<header>
						<div id="cabecalho" name="cabecalho" class="cabecalho-borda cabecalho-texto">Agende Seu Procedimento</div>
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
                                                class=\"form-component\" onchange=\"getProcedimentos();\"                    autocomplete=\"off\">";
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
				<div class="col-sm-12">
						<footer>
                            <a href="excluicookie.php">exclui cookie</a>
						</footer>
				</div>
            </div>
		</div>
        <section id="scripts">
                <script src="js/jquery.min.js"></script>
                <script src="js/jquery.js"></script>  
                <script src="js/bootstrap.min.js"></script>       
                <script src="js/jquery-ui.min.js"></script>
                <script src="js/ajax.js"></script>
                <script src="js/jquery-ui-add.js"></script>
                <script src="js/principal.js"></script></section>
    </body>
</html>
