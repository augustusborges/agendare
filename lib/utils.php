<?php


    // PHP will fatal error if we attempt to use the DateTime class without this being set.
    date_default_timezone_set('UTC');


    class Event {

        // Tests whether the given ISO8601 string has a time-of-day or not
        const ALL_DAY_REGEX = '/^\d{4}-\d\d-\d\d$/'; // matches strings like "2013-12-29"

        public $title;
        public $allDay; // a boolean
        public $start; // a DateTime
        public $end; // a DateTime, or null
        public $properties = array(); // an array of other misc properties


        // Constructs an Event object from the given array of key=>values.
        // You can optionally force the timezone of the parsed dates.
        public function __construct($array, $timezone=null) {

            $this->title = $array['title'];

            if (isset($array['allDay'])) {
             // allDay has been explicitly specified
            $this->allDay = (bool)$array['allDay'];
            }
            else {
                // Guess allDay based off of ISO8601 date strings
                $this->allDay = preg_match(self::ALL_DAY_REGEX, $array['start']) &&
               (!isset($array['end']) || preg_match(self::ALL_DAY_REGEX, $array['end']));
            }

            if ($this->allDay) {
                // If dates are allDay, we want to parse them in UTC to avoid DST issues.
              $timezone = null;
            }

            // Parse dates
            $this->start = parseDateTime($array['start'], $timezone);
            $this->end = isset($array['end']) ? parseDateTime($array['end'], $timezone) : null;

            // Record misc properties
            foreach ($array as $name => $value) {
                if (!in_array($name, array('title', 'allDay', 'start', 'end'))) {
                    $this->properties[$name] = $value;
                }
            }
        }


        // Returns whether the date range of our event intersects with the given all-day range.
        // $rangeStart and $rangeEnd are assumed to be dates in UTC with 00:00:00 time.
        public function isWithinDayRange($rangeStart, $rangeEnd) {

            // Normalize our event's dates for comparison with the all-day   range.
            $eventStart = stripTime($this->start);

            if (isset($this->end)) {
                $eventEnd = stripTime($this->end); // normalize
            }
            else {
                $eventEnd = $eventStart; // consider this a zero-duration event
            }

            // Check if the two whole-day ranges intersect.
            return $eventStart < $rangeEnd && $eventEnd >= $rangeStart;
        }


        // Converts this Event object back to a plain data array, to be used for generating JSON
        public function toArray() {

            // Start with the misc properties (don't worry, PHP won't affect the original array)
            $array = $this->properties;

            $array['title'] = $this->title;

            // Figure out the date format. This essentially encodes allDay into the date string.
            if ($this->allDay) {
                $format = 'Y-m-d'; // output like "2013-12-29"
            }
            else {
                $format = 'c'; // full ISO8601 output, like "2013-12-29T09:00:00+08:00"
            }

            // Serialize dates into strings
            $array['start'] = $this->start->format($format);
    
            if (isset($this->end)) {
                $array['end'] = $this->end->format($format);
            }

            return $array;
        }
    }

    // Parses a string into a DateTime object, optionally forced into the given timezone.
    function parseDateTime($string, $timezone=null) {
        $date = new DateTime(
        $string,
        $timezone ? $timezone : new DateTimeZone('UTC')
      // Used only when the string is ambiguous.
      // Ignored if string has a timezone offset in it.
        );
        
        if ($timezone) {
            // If our timezone was ignored above, force it.
            $date->setTimezone($timezone);
        }
        return $date;
    }

    // converts the year/month/date of the given DateTime in a new UTC DateTime
    function stripTime($datetime) {
        
        return new DateTime($datetime->format('Y-m-d'));
    }

    //Monta Select com possibilidade de seleção multipla
    function montaMultiploSelect($arrayCats){
        // calcula o número de índices do array
        $catsSize = count( $arrayCats );
        echo "<select size=6 multiple name=\"colaboradores[]\" id=\"selectable\"  required>";
        for ( $i = 1; $i <= $catsSize; $i++ ){
            echo "<option "
                ." value=".$arrayCats[$i]['id']
                ." class=\"ui-widget-content\">";
            echo $arrayCats[$i]['nome'];
            echo "</option>";
        }
        echo "</select>";
    }

    //Monta Select com possibilidade de seleção multipla
    function montaSimplesSelect($arrayCats, $nomeSelect, $selected){
        // calcula o número de índices do array
        $catsSize = count( $arrayCats );
        echo "<select name=\"$nomeSelect\" id=\"$nomeSelect\"  required>";
        echo "<option value=\"0\" default>Selecione Opção</option>";
        for ( $i = 1; $i <= $catsSize; $i++ ){
            if($arrayCats[$i]['id'] != $selected){
                echo "<option "
                    ." value=".$arrayCats[$i]['id']
                    ." class=\"ui-widget-content\">";
                echo $arrayCats[$i]['nome'];
                echo "</option>";
            }else{
                echo "<option "
                    ." value=".$arrayCats[$i]['id']
                    ." class=\"ui-widget-content\" selected>";
                echo $arrayCats[$i]['nome'];
                echo "</option>";
            }
        }
        echo "</select>";
    }

    //Monta Select com possibilidade de seleção multipla
    function montaSimplesSelectAjax($arrayCats, $nomeSelect, $selected, $funcao, $label){
        // calcula o número de índices do array
        $catsSize = count( $arrayCats );
        echo "<label class=\"form-label\">$label</label>";
        echo "<select name=\"$nomeSelect\" id=\"$nomeSelect\" class=\"form-component\" onchange=\"$funcao\" required>";
        echo "<option value=\"0\" default>Selecione Opção</option>";
        for ( $i = 1; $i <= $catsSize; $i++ ){
            if($arrayCats[$i]['id'] != $selected){
                echo "<option "
                    ." value=".$arrayCats[$i]['id']
                    ." class=\"ui-widget-content\">";
                echo $arrayCats[$i]['nome'];
                echo "</option>";
            }else{
                echo "<option "
                    ." value=".$arrayCats[$i]['id']
                    ." class=\"ui-widget-content\" selected>";
                echo $arrayCats[$i]['nome'];
                echo "</option>";
            }
        }
        echo "</select>";
    }
    
    // escrever o que se faz
    function montaAgenda($colaboradores, $dataini, $datafim, $diasTrabalho, $horasTrabalho){

        $agendaTrabalho = array();
        $idtfy=1;
        
        //Para cada colaborador informado
        for ($i=0;$i < count($colaboradores);$i++){

            //Obtem o range de data para montagem da agenda
            $datainicial = strtotime(converteData($dataini));
            $datafinal = strtotime(converteData($datafim));
            $dataincremento = $datainicial;
            
            //Para cada dia selecionado 
            while($dataincremento <= $datafinal){

                //Obtem o nome do dia da semana em portugues
                $diasemana = converteDiaSemana(date('l', $dataincremento));
                
                //Para cada dia da semana
                foreach($diasTrabalho as $chave => $valor) {
                    // se for um dia de trabalho (esta selecionado)
                    if($diasemana == $chave && $valor){
                         
                        //converte data para padrão Mysql
                        $dia = date('Y/m/d', $dataincremento);

                        
                        
                        //Para cada hora do dia
                        foreach($horasTrabalho as $chave => $valor){
                            
                            //Se for hora de trabalho (está selecionada)
                            if($valor){
                                $agendaTrabalho[$idtfy]['empresa'] = 1;
                                $agendaTrabalho[$idtfy]['colab'] = $colaboradores[$i];
                                $agendaTrabalho[$idtfy]['dia'] = $dia;
                                $agendaTrabalho[$idtfy]['hora'] = $chave;
                                $agendaTrabalho[$idtfy]['livre'] = true;
                        
                                $idtfy++;
                            }
                        }
                    }
                }

                $dataincremento = strtotime('+1 day', $dataincremento);
            }

        }
        
        return $agendaTrabalho;
    }

    // Apresenta os colaboradores ao usuário num DropDown
    function mostraProcedimentos($arrayCats){
        // calcula o número de índices do array
        $catsSize = count( $arrayCats );
        echo "<select size=6 name=\"procedimentos[]\" onchange=\"showHint(this.value)\">";
        for ( $i = 1; $i <= $catsSize; $i++ ){
            echo "<option "
                ." value=".$arrayCats[$i]['id']
                ." class=\"ui-widget-content\">";
            echo $arrayCats[$i]['nome'];
            echo "</option>";
        }
        echo "</select>";
    }

    //Converte data de padrão brasileiro para padrão americano
    function converteData($data){
        
        return (preg_match('/\//',$data)) ? implode('-', array_reverse(explode('/', $data))) : implode('/', array_reverse(explode('/', $data)));
    }
                    
    //Converte nome do dia da semana do padrão BR para padrão USA
    function converteDiaSemana($dia){
        
        $diaSemana="";
            
        switch($dia){
            case "Sunday":
                $diaSemana="Domingo";
                break;
            case "Monday":
                $diaSemana="Segunda";
                break;
            case "Tuesday":
                $diaSemana="Terca";
                break;
            case "Wednesday":
                $diaSemana="Quarta";
                break;
            case "Thursday":
                $diaSemana="Quinta";
                break;
            case "Friday":
                $diaSemana="Sexta";
                break;
            case "Saturday":
                $diaSemana="Sabado";
                break;
        }
        return $diaSemana;
    }
 
    //Documentar
    function montaRadioButton($arrayCats, $idRadio, $label){

        echo "<label class=\"sublabelChique\">$label</label>";
        echo "<div id=\"horasDisponiveis\">";   
        $count = count($arrayCats);
            for($i=1; $i <= $count; $i++){
                echo "<label class=\"container\">"
                        .$arrayCats[$i]['nome']
                        ."<input type=\"radio\" name=\"$idRadio\" value=\"".$arrayCats[$i]['nome']."\" />"
                        ."<span class=\"checkmark\"></span>"
                    ."</label>"; 
            }
        echo "</div>";
    }
    
    //Criptografa o dado passado na função
    function encriptar($dado){
        $senhaCriptografada = password_hash($dado, PASSWORD_DEFAULT);
        return $senhaCriptografada;
    }

    //Cria um arquivo Json no padrão fullcalendar paa armazenar os eventos de um cliente logado
    function criaEventosCliente($eventos){

        $string = array();

        $totalRegistro = count($eventos);
        for($i = 1; $i <= $totalRegistro; $i++){

            $mhora = (substr($eventos[$i]['hora'], 0, -3) + 1).":00:00";
            $string[$i]['title'] = $eventos[$i]['procedimento']." ".$eventos[$i]['empresa'];
            $string[$i]['start'] = date('Y-m-d', strtotime($eventos[$i]['dia']))."T".$eventos[$i]['hora'].":00";
            $string[$i]['end'] =  date('Y-m-d', strtotime($eventos[$i]['dia']))."T".$mhora;
            $string[$i]['overlap'] = false;
        }

        $caminho = BASE_DIR. 'diretorio' . DS . $_SESSION['sessionId'];
        $fp = fopen($caminho.'/arquivo.json', 'w');
        fwrite($fp, json_encode($string));
        fclose($fp);                
    }

    //Cria um arquivo Json no padrão fullcalendar
    function criaEventos($eventos){

        $string = array();

        $totalRegistro = count($eventos);

        for($i = 1; $i <= $totalRegistro; $i++){

            $string[$i]['title'] = "Dia Disponivel";
            $string[$i]['start'] = date('Y-m-d', strtotime($eventos[$i]['dia']));
            $string[$i]['end'] =  date('Y-m-d', strtotime($eventos[$i]['dia']));
            $string[$i]['overlap'] = false;
            $string[$i]['rendering'] = "background";
            $string[$i]['color'] = "#AFF5DF";
        }

        criaJson(BASE_DIR.'json/arquivo.json', $string);
    }

    //A partir de um array cria um arquivo Json em um caminho determinado
    function criaJson($caminho, $dados){

       $fp = fopen($caminho, 'w');
        fwrite($fp, json_encode($dados));
        fwrite($fp, "teste");
        fclose($fp);                
    }
     
    //A partir de um array cria um arquivo Json em um caminho determinado
    function criaArquivo($caminho, $dados){
        $fp = fopen($caminho, 'w');
        fwrite($fp, $dados);
        fclose($fp);                
    }

    function consoleLog($dado){

        $output = $dado;
        
        if ( is_array( $output ) )
            $output = implode( ',', $output);

        echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
    }
?>