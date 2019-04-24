<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <meta name="author" content="Focus4 Business Intelligence Ltda"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <title>daab - Agendamento</title>

    <links>
      <link rel="stylesheet" href="css/bootstrap.css"/>
      <link rel="stylesheet" href="css/jquery-ui.css"/>
  		<link rel="stylesheet" href="css/halflings.css"/>
      <link rel="stylesheet" href="css/mine.css"/>
  		<link rel="stylesheet" href="css/principal.css"/>
  		<link rel="stylesheet" href="css/grafico_principal.css"/>
    </links>
  </head>
  <body>
    <div class="container-fluid body_color">
      <div class="row" id="php">
        <?php
          include 'config.php';
          include BASE_DIR.'lib'.DS.'utils.php';
          include BASE_DIR.'model'.DS.'pessoa.php';
          include BASE_DIR.'model'.DS.'agenda.php';
        ?>
      </div>

      <div class="row" id="menu">
        <?php include BASE_DIR.'view'.DS.'_menu.php';?>
      </div>

      <div class="row" id="cabecalho">
        <div class="col-sm-12">

          <header>
            <div id="cabecalho" name="cabecalho" class="cabecalho-borda cabecalho-texto">Dados de Gerenciamento</div>
          </header>
        </div>
      </div>

      <div class="row" id="graficos">
        <div class="col-sm-4">
          <div class="box span6">
            <div class="box-header" data-original-title>
              <h2>
                <i class="halflings-icon white list-alt"></i>
                <span class="break"></span>
                Maiores Vendedores
              </h2>
              <div class="box-icon">
                <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
                <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
                <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
              </div>
            </div>
            <div class="box-content">
              <div id="donutchart"  style="width:100%;height:300px;"></div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="box span6">
            <div class="box-header" data-original-title>
              <h2>
                <i class="halflings-icon white list-alt"></i>
                <span class="break"></span>Melhores Clientes
              </h2>
              <div class="box-icon">
                <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
                <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
                <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
              </div>
            </div>
            <div class="box-content">
              <div id="outrochart" style="width:100%;height:300px;"></div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="box span6">
            <div class="box-header" data-original-title>
              <h2>
                <i class="halflings-icon white list-alt"></i>
                <span class="break"></span>Vendas Mensais
              </h2>
              <div class="box-icon">
                <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
                <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
                <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
              </div>
            </div>
            <div class="box-content">
              <div id="barrachart" style="width:100%;height:300px;"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="row" id="graficos2">
        <div class="col-sm-4">
          <div class="box span6">
            <div class="box-header" data-original-title>
              <h2>
                <i class="halflings-icon white list-alt"></i>
                <span class="break"></span>Vendas (Previsto x Realizado)
              </h2>
              <div class="box-icon">
                <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
                <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
                <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
              </div>
            </div>
            <div class="box-content">
              <div id="chart1" style="width:100%;height:300px;"></div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="box span6">
            <div class="box-header" data-original-title>
              <h2>
                <i class="halflings-icon white list-alt"></i>
                <span class="break"></span>Grafico Nada Ainda
              </h2>
              <div class="box-icon">
                <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
                <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
                <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
              </div>
            </div>
            <div class="box-content">
              <div id="chart2" style="width:100%;height:300px;"></div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="box span6">
            <div class="box-header" data-original-title>
              <h2>
                <i class="halflings-icon white list-alt"></i>
                <span class="break"></span>Grafico nada Ainda
              </h2>
              <div class="box-icon">
                <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
                <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
                <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
              </div>
            </div>
            <div class="box-content">
              <div id="chart3" style="width:100%;height:300px;"></div>
            </div>
          </div>
          <span id="hoverdata"></span>
          <span id="clickdata"></span>
        </div>
      </div>
    </div>

    <section id="scripts">
        <script src="js/jquery.js"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/jquery-ui-add.js"></script>
        <script src="js/jquery.flot.js"></script>
        <script src="js/jquery.flot.resize.js"></script>
        <script src="js/jquery.flot.categories.js"></script>
        <script src="js/jquery.flot.pie.js"></script>
        <script src="js/jquery.flot.stack.js"></script>
        <script src="js/jquery.flot.crosshair.js"></script>
    	  <script src="js/excanvas.js"></script>
        <script src="js/graficos.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/principal.js"></script>
      </section>
  </body>
</html>

<!-- <?php
  // $agenda = new agenda();
  //
  // $relacaoProcedimentos = $agenda->relacaoProcedimentosAgendados(1, '2018-03-28', '2018-03-30', 1);
  // var_dump($relacaoProcedimentos);
  //
  //                   $valoresAgendados = $agenda->relacaoValoresAgendados('2018-03-28', '2018-03-30');
  //                   //var_dump($valoresAgendados);
  //
  //                   $valoresAgendadosCliente = $agenda->relacaoValoresAgendadosCliente('2018-03-28', '2018-03-30');
  //                   //var_dump($valoresAgendadosCliente);
  //
  //                   $arr = "[";
  //                   for($i=1; $i<=count($valoresAgendadosCliente); $i++){
  //                     $arr = $arr.'{'.'"label"'.':"'.$valoresAgendadosCliente[$i]['nomeCliente'].'"'.', "data":'.  $valoresAgendadosCliente[$i]['valor'];
  //
  //                     if($i<count($valoresAgendadosCliente)){
  //                       $arr = $arr.'},';
  //                     }else{
  //                       $arr = $arr.'}';
  //                     }
  //                   }
  //                   $arr = $arr."]";
  //
  //                   $caminho = BASE_DIR."config".DS."alexandre.json";
  //
  //                   criaArquivo($caminho, $arr);
  //
  //
  //                   $AgendamentoClientePeriodo = $agenda->numeroAgendamentoClientePeriodo('2018-03-28', '2018-03-30');
  //                   //var_dump($AgendamentoClientePeriodo);
?> -->
