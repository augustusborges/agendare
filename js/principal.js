$(function(){  
    $("#cabecalho").mouseover(function(){
        $('#cabecalho').addClass("icone-color-navbar-nok");
    });
});

$(function(){
    $("#cabecalho").mouseleave(function(){
        $('#cabecalho').removeClass("icone-color-navbar-nok");
        //$('#cabecalho').addClass("icone-color-navbar-ok");
    });
});

$(function(){  
    $("#cabecalho").click(function(){
        alert("A div foi clicada.");
    });
});

$(function(){  
    $("#agendar").click(function(){
        alert("A submit foi clicada.");
    });
});

//Exemplo de tratamento de 
$("#login").click(function(){
    if(!$('#loginIcone').hasClass("icone-color-navbar-nok")){
        $('#loginIcone').addClass("icone-color-navbar-ok");
    }
    else{
        $('#loginIcone').addClass("icone-color-navbar-nok");
    }
});

//Verifica se a sessão esta logada para poder agendar um procedimento
function valida_sessao(sessao){
    if(sessao.value == 1000){
        alert("Você precisa estar logado para fazer um agendamento! Obrigado!");
        return false;
        form.submit();
    }
    else if(sessao.value == 5000){
        form.submit();
    }
}