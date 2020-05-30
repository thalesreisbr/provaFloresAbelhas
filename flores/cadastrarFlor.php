<!DOCTYPE html>	
<html>
<head>
	<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body align="center">
<!--
Esta página se utilizou de alguns recursos deselegantes, ao começar a programa-la não sabia-se utilizar ajax, deste modo o modo em que se enviou os meses selecionado foi criando <input type="hidden" e altera seu valor caso ele tivesse, entende-se também que  gerar meses a partir de um vetor comum nao é uma boa pratica, deveria-se pegar de uma tabela no DB.

Outra componente que gerou muita dificuldade por falta de conhecimento foi de como selecionar as abelhas, não tenho conhecimento em componentes prontos de bootstrap.   Deste modo utilizou-se um select multiple para selecionar.

-->
<div id="bodyCadastrarFlor">
<p class="tituloCadastrarFlor">Cadastrar flor</p>
</div>
<p class="descricaoCadastrarFlor">Cadastre as flores de acordo com o mês em que ela floresce</div>
<br><br>

<form name="formu" id="formu" action="LoadCadastrarFlor.php" method="POST" enctype="multipart/form-data">
	

	<div class="labelFormu">Nome</div>	

	<input type="text" id="nomeFlor" name="nome" placeholder="Qual o nome da Flor" class="inputTextCadastroFlor" required="">
	
	<input type="file" name="imagem" id="file"  required="">
	<div id="textoEscolhaImagem">Selecione a Imagem</div>

	<div class="labelFormu">Especie</div>
	<input type="text" id="especieFlor" name="especie" placeholder="Qual a especie ou nome cientifico" class="inputTextCadastroFlor" required="">
	<div class="labelFormu">Descriçao</div>
	<input type="text" id="descricaoFlor" name="descricao" placeholder='Escreva uma breve descriçao sobre a flor' class="textAreaCadastroFlor" required="">
	
	
	<br>
	<?php
		$meses = array('Jan', 'Fev', 'Mar', 'Abril', 'Maio', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov',  'Dez');
		for ($i=0; $i < 12; $i++) { 
			echo '<input type="button" class="botaoMes" value="'.$meses[$i].'" id="'.$meses[$i].'" onclick="clicarBotao('.$meses[$i].','.$i.')" >';

		}
		for ($i=1; $i < 13; $i++) { 
			echo '<input type="hidden" value="0" name="'.$i.'">';
		}
		/* */
		require_once 'conexao/Connection.php';
		require_once 'conexao/PoolConnection.php';

		$con1 = new Connection();
		$pooll = new PoolConnection();
	    $pooll->addConnection($con1);
		$mysqli = $pooll->getConnection();

		$sql_code = "SELECT id,nome FROM abelha";
	?>
	<div class="labelFormu">Selecione as abelhas que polinização essas flores</div>	
	<div class="form-row margin">

		<div class="col">
			<div class="card">
	 		 	<div class="card-body">
	   			
	  			</div>
			</div>		
		</div>
		<div class="col">
			<?php
			echo "<select multiple name='abelhas' id='abelha' class='form-control'>";
			$i = 0;
				foreach ($mysqli->query($sql_code) as $row) {
					$nome = $row['nome'];
		    		echo "<option id='$nome' onclick='clicarSelect(".$i.")'> $nome </option>";
		    		$i++;
				}
			echo "</select>";
			?>				
		</div>
	</div>
	
	<input type="button" name="cancela" class="botaoCancelar"  onclick="cancel()" value="Cancelar"> 
	
	
	<input  class="botaoSubmitCadastroFlor" type="submit" name="submit" placeholder="ok">
		

	
	
	
</form>
<script type="text/javascript">
	function cancel(){
		console.log("Cancela");
		window.location.assign("index.php");
	}

	function clicarBotao(id,j){
		/* Está função faz de uma maneira não conviente a adaptação de dados que deveriam ser enviado via ajax POST para LoadCadastrar,
			alterando o valor de hidden, e também fez um efeito basico para mostrar pro usuario com mes esta selecionado.

			E deveria ter sido otimizada, para nao trabalhar com essa comparaçao de tipo da borda para verificar se esta selecionada, e sim criando um atributo selected como foi na página inicial
		*/
		var e = document.getElementById(id.value);
		var h = document.getElementsByName(j+1);
		if(e.style.borderStyle != "ridge"){
			e.style.borderStyle = "ridge";
			e.style.backgroundColor = "#FFBED7";
			h[0].value = id.value;
		}else{
			e.style.borderStyle = "solid";
			e.style.backgroundColor = " white";
			h[0].value = '0';	
		}
	}
	var abelhas = [];
	function clicarSelect(id){
		/* Esta função vem de um onclick nos option do select multple de abelha com ela atribui-se o valor do atributo selected e se caso ja estiver selecionado, ele coloca o selected vazio para nao selecionar e depois ele coloca em uma div todos que estao com atributo selecionado e tambem todos que estao selecionados sao atribuidos a um vetor global abelhas, acredito eu que está não seja uma boa prática.

		 */
		console.log("Clicou");
		e = document.getElementsByClassName('card-body');

		if(document.formu.abelhas.options[id].getAttribute('selected')  == "selected"){
			document.formu.abelhas.options[id].setAttribute('selected', '');
			console.log("ja foi selecionado");

		}else{
			console.log(document.formu.abelhas.options[id].getAttribute('selected'));
		 	document.formu.abelhas.options[id].setAttribute('selected', 'selected');
		}
		var card = "";
		let opts = $("select option");
   		var tamanhoSelect = opts.length;
   		e[0].innerHTML = "";
   		var j=0;
		for (i = 0; i<tamanhoSelect; i++){

			if(document.formu.abelhas.options[i].getAttribute('selected')  == "selected"){
			
				string = "<span class='selecionadoAbelha'  >" +document.formu.abelhas.options[i].text+"</span>"
				
				e[0].innerHTML = e[0].innerHTML +string;
				abelhas[j] = document.formu.abelhas.options[i].text;
				console.log(abelhas[j]);
				j+=1;
				abelhas[j] = 0;

			}
		}
		//console.log(document.formu.abelhas.options[id]);
	}
	/*Aqui é o Json que a chamo no evento onsubit do formulario os meses selecionados já estão contidos no input hidden e abelhas selecionads sao adicionar no formData, os meses deveriam ter feito com foi feito com abelhas seria um pouco melhor*/
	 $("#formu").on('submit',(function(e) {
	  e.preventDefault();
	  data = new FormData(this);
	  //abelhas = getAbelhas();
	  for (var i = 0; i < abelhas.length; i++) {
	  	data.append('abelhas[]',abelhas[i])
	  }
	  $.ajax({
	         url: "LoadCadastrarFlor.php",
	   type: "POST",
	   data:  data,
	   contentType: false,
	         cache: false,
	   processData:false,
	   beforeSend : function()
	   {
	    //$("#preview").fadeOut();
	    
	   },
	   success: function(data)
	      {
	    	
	    	$('#imprima').prepend(data);
	    	alert("Cadastrado Com Sucesso");
	      },
	     error: function(e) 
	      {
	    
	      }          
	    });
	 }));
	</script>

</body>
</html>