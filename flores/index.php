<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="../bootstrap-3.3.6/css/bootstrap.css">	
    <link rel="stylesheet" href="../bootstrap-3.3.6/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="script.js"></script>
</head>
<body align="center">
	<div class="botaoCadastrarFlor" onclick='trocarPagina("cadastrarFlor.php");'><p class="TextoCadastroFlor">Cadastrar Flor</p></div>
	<div class="titulo">Calendário de Flores</div>
	<div class="descricao">
		Neste calendario encontra-se disversas flores.<br>
		Podem ser agrupada pelos meses que florem e pelo tipo de abelha poliniza a flor.
	</div>
	<div class="boxSelecaoAbelhas">
		<?php
			selectAbelha();
		?>
	</div>
	<div id="mesesIndex">
		<?php
			botaoMeses();
		?>
	</div>
	<table id="corpoFlores">
		
			<?php
			//include "corpoFlores.php";
			//corpoFlores();	
				
			?>
			<script type="text/javascript">
				window.onload = function(){
    				carregaCorpoMeses(0,0);
			}
		</script>
		
	</table>
	<?php

		function selectAbelha(){
			require_once 'conexao/Connection.php';
			require_once 'conexao/PoolConnection.php';

			$con1 = new Connection();
			$pooll = new PoolConnection();
		    $pooll->addConnection($con1);
			$mysqli = $pooll->getConnection();

			$sql_code = "SELECT id,nome FROM abelha";

			echo "<select name='abelhas' id='selectAbelhaIndex' onchange='selecaoAbelha()'>";
			echo "<option value='0'></option>";
			foreach ($mysqli->query($sql_code) as $row) {
				$nome = $row['nome'];
				$idAbelha = $row['id'];
			    echo "<option value='$idAbelha' id='$nome' onclick='clicarSelect(".$nome.",".$idAbelha.")'> $nome </option>";
			}

			echo "</select>";
	}
		function botaoMeses(){
			$meses = array('Jan', 'Fev', 'Mar', 'Abril', 'Maio', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov','Dez');
			for ($i=0; $i < 12; $i++) {
				/* Teve se de fazer esse If pois id Set é palavra reservada, deste modo fez-se essa exceção */
				if($i ==8){
					echo '<input  type="button" value="'.$meses[$i].'" class="botaoMes" id="setembro" onclick="uploadCorpoMeses('."setembro".')" style="border-color:white;" >';
				}else	echo '<input  type="button" value="'.$meses[$i].'" class="botaoMes" id="'.$meses[$i].'" onclick="uploadCorpoMeses('.$meses[$i].')" style="border-color:white;" >';

			}
		}
		
	?>

</body>
</html>