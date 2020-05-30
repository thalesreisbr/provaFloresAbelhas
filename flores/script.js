
function getMeses(){
	e =document.getElementsByTagName("input");
	var meses = [];
	var j=0;

	for (var i = 0; i < 12; i++) {
		if(e[i].getAttribute("selected") == "selected"){
			meses[j] = e[i].value;

			//console.log(meses[j]);
			j++;
		}
	}
 	return meses;
}
		
function trocarPagina(url){
	window.location.assign(url);
}

function uploadCorpoMeses(idMes){
	/*Esta funçao observa-se o que teria que ter feito com meses na página castrar flor, não foi utilizado o recurso do
	ipunt hidden que é muito sujeito a erro e ocorre alguns sacrificios devido a isso. Nessa função utiliza do atributo slected para
	verificação se o mes foi selecionado  e ela ja chama a funcao que faz a requisicao no servidor*/
	
	console.log(idMes);
	var e = document.getElementById(idMes.id);
	
		if(e.getAttribute("selected") == "selected"){
			e.setAttribute('selected', '');
			e.style.backgroundColor = "white";
		}else{
			e.setAttribute('selected', 'selected');
			e.style.backgroundColor = "#FFBED7";
		}

	carregaCorpoMeses(getMeses(),0);	
}
function carregaCorpoMeses(meses, abelhas){

	$.ajax({
		 url: 'corpoFlores.php',
		 method: 'post',
		 data: {
		  meses: meses
		 }
		}).done(function(resposta){
			var e = document.getElementsByTagName('table');
			e[0].innerHTML = resposta;
		}).fail(function(erro){
		 	window.alert('Erro: ' + erro);
		});
				
}
function selecaoAbelha(){
	var e = document.getElementsByName('abelhas');
	
	//console.log("Nesta selecao de abelhas");
	//console.log(e[0].value);
	abelha = e[0].value;
	$.ajax({
		 url: 'corpoFlores.php',
		 method: 'post',
		 data: {
		  abelhas: abelha
		 }
		}).done(function(resposta){
			var e = document.getElementsByTagName('table');
			e[0].innerHTML = resposta;
		}).fail(function(erro){
		 	window.alert('Erro: ' + erro);
		});
}