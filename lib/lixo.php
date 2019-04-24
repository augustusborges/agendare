<?php
    require '../config.php';
    
    include("../model/procedimento.php");
    include("../model/colaborador.php");
    include("../dao/agendaDao.php");

    $procedimento = new procedimento();
    $colaborador = new colaborador();

	$tipo = (isset($_GET["tipo"])?$_GET["tipo"]:0);

    if($tipo == 0){
		if (isset($_GET["empresa"])) {
			$procedimentos = 
            $procedimento->procedimentosDisponiveisDataEmpresa(date('Y/m/d', strtotime(converteData($_GET["dia"]))), $_GET["empresa"]);
		}
	}elseif($tipo==1){
		if (isset($_GET["procedimento"])) {
			$profissionais = $colaborador->profissionaisDisponiveisProcedimentoDataEmpresa(date('Y/m/d', strtotime(converteData($_GET["dia"]))), $_GET["empresa"], $_GET["procedimento"]);
		}
	}elseif($tipo==2){
		if (isset($_GET["profissional"])) {
			$empresa = $_GET["empresa"];
			$dia = $_GET["dia"];
			$procedimento =  $_GET["procedimento"];
			$profissional =  $_GET["profissional"];
		
			$horasDisponiveis = horasDisponiveis(date('Y/m/d',strtotime(converteData($dia))), $empresa, $profissional);
			$idRadio = "horaAgendada";
			montaRadioButton($horasDisponiveis, $idRadio, "Hora:");   

		}
	}
   
?>





