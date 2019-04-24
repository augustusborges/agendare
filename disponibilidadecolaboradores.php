<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="description" content=""/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>

        <title>cria agenda de colaboradores</title>

        <links>
            <link rel="stylesheet" href="css/bootstrap.css"/>
            <link rel="stylesheet" href="css/jquery-ui.css"/>
            <link rel='stylesheet' href='css/fullcalendar.min.css'/>
            <link rel='stylesheet' href='css/calendario.css'/>
            <link rel="stylesheet" href="css/mine.css"/>
            <link rel="stylesheet" href="css/principal.css"/>
        </links>
    </head>
    <body>
        <div class="container-fluid body_color">
        
            <div class="row" id="php">
                <?php
                    require_once 'config.php';
                    require_once BASE_DIR.'lib'.DS.'utils.php';
                    require_once BASE_DIR.'model'.DS.'colaborador.php';
                    require_once BASE_DIR.'model'.DS.'pessoa.php';
                    require_once BASE_DIR.'dao'.DS.'agendaDao.php';

                    $colaborador = new colaborador();

                ?>
            </div>
            
            <div class="row" id="menu">
                <?php include BASE_DIR.'view'.DS.'_menu.php';?>
                <bold></bold>
            </div>
 
            <header>
                <h4>Cria agenda de colaboradores</h4>
                <hr  class="hr_meu"/> 
            </header>
             
            <section id="armazenaagenda">
                <?php
					//Esta seção monta a agenda do colaborador inserida na página montaagenda
					//E a armazena no banco de dados


					//obtem período para criacao de agenda
                    $dtini = (isset($_POST['dt_ini']))?date('d/m/Y',strtotime(converteData($_POST['dt_ini'])))
                                                               :null;
                    $dtfim = (isset($_POST['dt_fim']))?date('d/m/Y',strtotime(converteData($_POST['dt_fim'])))
                                                                :null;

                    //obtem lista de colaboradores
                    $colaboradores = ((isset($_POST["colaboradores"]))?$_POST["colaboradores"] : false);

                    //obtem dias de trabalho para criação de agenda
                    $diasTrabalho = array(
                        "Domingo" => (isset($_POST['ckb_dom'])) ?true : false,
                        "Segunda" => (isset($_POST['ckb_seg'])) ?true : false,
                        "Terca" => (isset($_POST['ckb_ter'])) ? true : false,
                        "Quarta" => (isset($_POST['ckb_qua'])) ? true : false,
                        "Quinta" => (isset($_POST['ckb_qui'])) ? true : false,
                        "Sexta" => (isset($_POST['ckb_sex'])) ? true : false,
                        "Sabado" => (isset($_POST['ckb_sab'])) ? true : false
                    );

                    //obtem horas de trabalho para criação de agenda
                    $horasTrabalho = array(
                        "06:00" => (isset($_POST['ckb_0600'])) ? true : false,
                        "07:00" => (isset($_POST['ckb_0700'])) ? true : false,
                        "08:00" => (isset($_POST['ckb_0800'])) ? true : false,
                        "09:00" => (isset($_POST['ckb_0900'])) ? true : false,
                        "10:00" => (isset($_POST['ckb_1000'])) ? true : false,
                        "11:00" => (isset($_POST['ckb_1100'])) ? true : false,
                        "12:00" => (isset($_POST['ckb_1200'])) ? true : false,
                        "13:00" => (isset($_POST['ckb_1300'])) ? true : false,
                        "14:00" => (isset($_POST['ckb_1400'])) ? true : false,
                        "15:00" => (isset($_POST['ckb_1500'])) ? true : false,
                        "16:00" => (isset($_POST['ckb_1600'])) ? true : false,
                        "17:00" => (isset($_POST['ckb_1700'])) ? true : false,
                        "18:00" => (isset($_POST['ckb_1800'])) ? true : false,
                        "19:00" => (isset($_POST['ckb_1900'])) ? true : false,
                        "20:00" => (isset($_POST['ckb_2000'])) ? true : false,
                        "21:00" => (isset($_POST['ckb_2100'])) ? true : false,
                        "22:00" => (isset($_POST['ckb_2200'])) ? true : false,
                        "23:00" => (isset($_POST['ckb_2300'])) ? true : false
                    );

                    //Chama função que armazena as agendas em banco de dados
                    $agendaTrabalho = montaAgenda($colaboradores, $dtini, $dtfim, $diasTrabalho, $horasTrabalho);
                    
                    //Insere registro no banco
                    criaAgenda($agendaTrabalho);
                ?>
            </section>

            <section id="apresentaagenda">
 
                <form action="disponibilidadecolaboradores.php" method="post">
                    <?php
					
                        //Pega a lista de todos os colaboradores de uma determinada empresa.
                        $listaColaboradores = listaColaborador(1);
                    
                        //Pega o colaborador selecionado na select da página caso haja
                        $colaboradorSelecionado = (isset($_POST["teste"])? $_POST["teste"]:0);

                        //Ou pega o ultimo colaborador da lista que vem da página montaagenda
                        if(is_array($colaboradores)){
                            $outroColaborador = end($colaboradores);
                        }

                        //Monta a seleção de colaboradores na tela
                        echo "<select id='teste' name='teste'>";
                        echo "<option>--Selecione Profissional--</option>";    
                    
                        $count = count($listaColaboradores);
                        for($i=1; $i <= $count; $i++){
                            //...e seleciona o colaborador marcado pelo usuário...
                            if($listaColaboradores[$i]['id'] == $colaboradorSelecionado){
                                echo "<option value=".$listaColaboradores[$i]['id']." selected>".$listaColaboradores[$i]['nome']."</option>"; 
                            }
							//...ou apresenta o ultimo da lista como selecionado
                            elseif($listaColaboradores[$i]['id'] == $outroColaborador){
                                echo "<option value=".$listaColaboradores[$i]['id']." selected>".$listaColaboradores[$i]['nome']."</option>";                    
                            }
                            else{
                              echo "<option value=".$listaColaboradores[$i]['id'].">".$listaColaboradores[$i]['nome']."</option>"; 
                            }
                        }
                        
                        echo "</select>";
                    ?>
                    <input type="submit" value=" Buscar Agenda"/>
                </form>
                <br/><br/>
                        
                <?php

                    $diasTrabalho = array();

                    if($colaboradorSelecionado > 0){
                        $diasTrabalho = obtemDiasTrabalhoColaborador($colaboradorSelecionado);
                        criaEventos($diasTrabalho);

                    }
                    else{
                        
                        $diasTrabalho = $colaborador->obtemDiasTrabalhoColaborador($outroColaborador);
                        criaEventos($agendaTrabalho);
                    }
                ?>
                
                <div id='script-warning'>
                    <code>lib/agendalivre.php</code> precisa estar rodando.
                </div>
                <div id="clndVisaoAgendaAberta"></div>
            </section>
            
            <section id="scripts"><!-- js files -->
                <script src="js/jquery.min.js"></script>
                <script src="js/bootstrap.min.js"></script>       
                <script src="js/jquery.js"></script>  
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