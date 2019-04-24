/*Funções AJAX*/

//Função para criar um objeto XMLHTTPRequest
function CriaRequest() {
    try{
        request = new XMLHttpRequest();        
    }
    catch (IEAtual)
    {
        try{
            request = new ActiveXObject("Msxml2.XMLHTTP");       
        }
        catch(IEAntigo)
        {
            try{
                request = new ActiveXObject("Microsoft.XMLHTTP");          
            }
            catch(falha){
                request = false;
            }
         }
     }
     
     if (!request) 
         alert("Seu Navegador não suporta Ajax!");
     else
         return request;
 }
 
// Função para enviar os dados
function getDados() {

     // Declaração de Variáveis
     var profissional  = document.getElementById("empresa").value;
     var dia  = document.getElementById("dt_agenda").value;
	 console.log(profissional);
     var result = document.getElementById("Resultado");
     var xmlreq = CriaRequest();
     
     // Exibi a imagem de progresso
     //result.innerHTML = '<img src="Progresso1.gif"/>';

     // Iniciar uma requisição
     xmlreq.open("GET", "/lib/lixo.php?profissional=" + nome +";dia=" + dia, true);
     
     // Atribui uma função para ser executada sempre que houver uma mudança de ado
     xmlreq.onreadystatechange = function(){
         
         // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
         if (xmlreq.readyState == 4) {
             
             // Verifica se o arquivo foi encontrado com sucesso
             if (xmlreq.status == 200) {
                 result.innerHTML = xmlreq.responseText;
             }else{
                 result.innerHTML = "Erro: " + xmlreq.statusText + profissional + dia;
             }
         }
     };
     xmlreq.send(null);
 }
 
// Busca os procedimentos disponiveis para uma determinada empresa em uma determinada data
function getProcedimentos() {

	// Declaração de Variáveis
    var empresa  = document.getElementById("empresa").value;
    var dia  = document.getElementById("dt_agenda").value;
    var result = document.getElementById("listaProcedimentos");

    var xmlreq = CriaRequest();
    xmlreq.open("GET", "lib/lixo.php?empresa="+empresa+"&dia="+dia+"&tipo=0", true);
    
    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){
         
		// Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
		if (xmlreq.readyState == 4) {
			// Verifica se o arquivo foi encontrado com sucesso
			if (xmlreq.status == 200) {
				result.innerHTML = xmlreq.responseText;
			}else{
				result.innerHTML = "Erro: " + xmlreq.statusText + profissional + dia;
			}
		}
	};
	xmlreq.send(null);
}

// Busca os profissionais dadas as informações de entrada
function getProfissionais() {

	// Declaração de Variáveis
    var empresa  = document.getElementById("empresa").value;
    var dia  = document.getElementById("dt_agenda").value;
	var procedimento = document.getElementById("procediments").value;
    var result = document.getElementById("listaProfissionais");

    var xmlreq = CriaRequest();
    xmlreq.open("GET", "lib/lixo.php?empresa="+empresa+"&dia="+dia+"&procedimento="+procedimento+"+&tipo=1", true);
    
    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){
         
		// Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
		if (xmlreq.readyState == 4) {
			// Verifica se o arquivo foi encontrado com sucesso
			if (xmlreq.status == 200) {
				result.innerHTML = xmlreq.responseText;
			}else{
				result.innerHTML = "Erro: " + xmlreq.statusText + profissional + dia;
			}
		}
	};
	
	xmlreq.send(null);
}

//Busca as horas disponiveis para um determinado profissional selecionado pelo cliente 
function getHorasDisponiveis() {

	// Declaração de Variáveis
    var empresa  = document.getElementById("empresa").value;
    var dia  = document.getElementById("dt_agenda").value;
	var procedimento = document.getElementById("procediments").value;
	var profissional = document.getElementById("profissionais").value;
    var result = document.getElementById("listaHoras");

    var xmlreq = CriaRequest();
    xmlreq.open("GET", "lib/lixo.php?empresa="+empresa+"&dia="+dia+"&procedimento="+procedimento+"&profissional="+profissional+"+&tipo=2", true);
    
    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){
         
		// Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
		if (xmlreq.readyState == 4) {
			// Verifica se o arquivo foi encontrado com sucesso
			if (xmlreq.status == 200) {
				result.innerHTML = xmlreq.responseText;
			}else{
				result.innerHTML = "Erro: " + xmlreq.statusText + profissional + dia;
			}
		}
	};
	
	xmlreq.send(null);
}
