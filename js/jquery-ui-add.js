
//Insere as caracteristicas do JQuery UI na aplicacao
$(function () {
    $("#dt_ini").datepicker({
        showOn: 'button',
        buttonImage: 'img/calendar.png',
        buttonImageOnly: true,
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    });

    $("#dt_fim").datepicker({
         showOn: 'button',
         buttonImage: 'img/calendar.png',
         buttonImageOnly: true,
         dateFormat: 'dd/mm/yy',
         dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
         dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
         dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
         monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
         monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
         nextText: 'Próximo',
         prevText: 'Anterior'
     });

    $("#dt_agenda").datepicker({
        //showOn: 'button',
        //buttonImage: '../../css/images/calendar.png',
        //buttonImageOnly: true,
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    });

    $("#selectable").selectable();

    $("#dias_semana").controlgroup();

    $("#horas_trabalho").controlgroup();

	$("#horasDisponiveis").controlgroup();

    $("#radio").checkboxradio();

    $(document).tooltip();

});

//Chamada AJAX
function showHint(str) {
    if (str.length == 0) {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "agendar.php?q=" + str, true);
        xmlhttp.send();
    }
}
