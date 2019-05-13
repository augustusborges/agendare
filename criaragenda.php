<?php
  session_start();
  error_reporting(E_ALL|E_STRICT);
  require_once 'config.php';
  require_once BASE_DIR.'lib'.DS.'utils.php';
  require_once BASE_DIR.'model'.DS.'pessoa.php';
  $pessoa = new pessoa();

  if(($pessoa->usuarioLogado())['sucesso'] == false){
    echo "<script type='text/javascript'>window.location='index.php'; </script>";
  }
  else {
    consoleLog("que merda");
  }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="Author" content="Focus4 Business Intelligence Ltda"/>
        <meta name="description" content="Monta a agenda de disponbilidade dos profissionais"/>
        <meta name="keywords" content="agenda"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>

        <title>d.a.a.b - Monta Agenda dos Profissionais</title>

        <links>
            <link rel="stylesheet" href="css/bootstrap.css"/>
            <link rel="stylesheet" href="css/jquery-ui.css"/>
            <link rel="stylesheet" href="css/mine.css"/>
            <link rel="stylesheet" href="css/principal.css"/>
        </links>
    </head>
    <body>
        <div class="container-fluid body_color">

            <div class="row" id="php">
                <?php
                  require_once BASE_DIR.'model'.DS.'colaborador.php';
                  $colaborador = new colaborador();
                ?>
            </div>

            <div class="row" id="menu">
                <?php include BASE_DIR.'view'.DS.'_menu.php';?>
                <div></div>
            </div>

			      <div class="row" id="linha_cabecalho">
				      <div class="col-sm-12">
                <header>
                  <div id="cabecalho" name="cabecalho" class="cabecalho-borda cabecalho-texto">Monta Agenda de Colaborador</div>
                  <!-- <a href="#" title="texto para exibir." class="mine_float_right"> <img src="../../css/images/professor.png"/> </a>-->
                </header>
				      </div>

            <section id="formulario">
                <form action="disponibilidadecolaboradores.php" method="post">

                    <!-- Período de agendamento-->
                    <fieldset>
                    <legend>
                        Selecione período para criação de agenda:
                    </legend>

                    <label for="dt_ini">de:</label>
                    <input type="text" name="dt_ini" id="dt_ini" required>

                    <label for="dt_fim">até:</label>
                    <input type="text" name="dt_fim" id="dt_fim" required>
                    </fieldset>

                    <!-- Lista de colaboradores-->
                    <fieldset>
                      <legend>
                        Selecione os colaboradores para agendar:
                      </legend>

                      <?php
                        $colaboradores = $colaborador->listaColaboradores(1);
                        montaMultiploSelect($colaboradores);
                      ?>
                    </fieldset>

                    <!-- Dias de trabalho-->
                    <fieldset>
                      <legend>
                        Selecione os dias de trabalho:
                      </legend>

                      <div id="dias_semana">
                        <label for="ckb_dom">Domingo</label>
                        <input type="checkbox" name="ckb_dom" id="ckb_dom">

                        <label for="ckb_seg">Segunda</label>
                        <input type="checkbox" name="ckb_seg" id="ckb_seg">

                        <label for="ckb_ter">Terça</label>
                        <input type="checkbox" name="ckb_ter" id="ckb_ter">

                        <label for="ckb_qua">Quarta</label>
                        <input type="checkbox" name="ckb_qua" id="ckb_qua">

                        <label for="ckb_qui">Quinta</label>
                        <input type="checkbox" name="ckb_qui" id="ckb_qui">

                        <label for="ckb_sex">Sexta</label>
                        <input type="checkbox" name="ckb_sex" id="ckb_sex">

                        <label for="ckb_sab">Sabado</label>
                        <input type="checkbox" name="ckb_sab" id="ckb_sab">
                      </div>
                    </fieldset>

                    <!-- Horas de trabalho-->
                    <fieldset>
                        <legend>
                            Selecione o horário de trabalho:
                        </legend>

                        <div id="horas_trabalho">
                            <label for="ckb_0600">06:00</label>
                            <input type="checkbox" name="ckb_0600" id="ckb_0600">
                            <label for="ckb_0700">07:00</label>
                            <input type="checkbox" name="ckb_0700" id="ckb_0700">
                            <label for="ckb_0800">08:00</label>
                            <input type="checkbox" name="ckb_0800" id="ckb_0800">
                            <label for="ckb_0900">09:00</label>
                            <input type="checkbox" name="ckb_0900" id="ckb_0900">
                            <label for="ckb_1000">10:00</label>
                            <input type="checkbox" name="ckb_1000" id="ckb_1000">
                            <label for="ckb_1100">11:00</label>
                            <input type="checkbox" name="ckb_1100" id="ckb_1100">
                            <label for="ckb_1200">12:00</label>
                            <input type="checkbox" name="ckb_1200" id="ckb_1200">
                            <label for="ckb_1300">13:00</label>
                            <input type="checkbox" name="ckb_1300" id="ckb_1300">
                            <label for="ckb_1400">14:00</label>
                            <input type="checkbox" name="ckb_1400" id="ckb_1400"><br/>
                            <label for="ckb_1500">15:00</label>
                            <input type="checkbox" name="ckb_1500" id="ckb_1500">
                            <label for="ckb_1600">16:00</label>
                            <input type="checkbox" name="ckb_1600" id="ckb_1600">
                            <label for="ckb_1700">17:00</label>
                            <input type="checkbox" name="ckb_1700" id="ckb_1700">
                            <label for="ckb_1800">18:00</label>
                            <input type="checkbox" name="ckb_1800" id="ckb_1800">
                            <label for="ckb_1900">19:00</label>
                            <input type="checkbox" name="ckb_1900" id="ckb_1900">
                            <label for="ckb_2000">20:00</label>
                            <input type="checkbox" name="ckb_2000" id="ckb_2000">
                            <label for="ckb_2100">21:00</label>
                            <input type="checkbox" name="ckb_2100" id="ckb_2100">
                            <label for="ckb_2200">22:00</label>
                            <input type="checkbox" name="ckb_2200" id="ckb_2200">
                            <label for="ckb_2300">23:00</label>
                            <input type="checkbox" name="ckb_2300" id="ckb_2300">
                        </div>
                    </fieldset>

                    <input type="submit" value="Criar Agenda" id="submit" class="ui-button ui-widget ui-corner-all">
                </form>
            </section>

            <footer></footer>

            <section id="scripts">
                <script src="js/jquery.min.js"></script>
                <script src="js/bootstrap.min.js"></script>
                <script src="js/jquery-ui.min.js"></script>
                <script src="js/ajax.js"></script>
                <script src="js/jquery-ui-add.js"></script>
                <script src="js/principal.js"></script>
            </section>
        </div>
    </body>
</html>
