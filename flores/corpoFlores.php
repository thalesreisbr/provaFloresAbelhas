<?php
$mes = @$_POST['meses'];
$abelha = @$_POST['abelhas'];
	if($mes){
		corpoFlores($mes,0);
	}else if($abelha){
		corpoFlores(0,$abelha);
	}else corpoFlores(0,0);

function corpoFlores($meses,$abelha){
	/* 
		Está função foi feita para haver um pouco de polimorfismo, nos seus primeiros if ela pega os nome e id iImagem de acordo com a consulta que quer ser feita se é de meses ou abelhas ou mostrar todos, ela pode ser mais otimizada, ela está apenas exibindo em uma unica pagina e apenas 3*4  = 12 elementos, tem-se que impletar para gerar botoes para trocar a pagina de acordo com o tamanaho da consulta 
	*/
			require_once 'conexao/Connection.php';
			require_once 'conexao/PoolConnection.php';

			$con1 = new Connection();
			$pooll = new PoolConnection();
		    $pooll->addConnection($con1);
			$mysqli = $pooll->getConnection();

			if($meses){
				$aux = florescimento($meses);
				if($aux == 0)
					return 0;
				for ($i=0; $i < sizeof($aux); $i++) { 
					$sql_code = "SELECT nome,idIMagem FROM flor WHERE id=".$aux[$i];
					$res = $mysqli->query($sql_code);
					$res = $res->fetchAll();
					$result[$i] = $res[0];
					//echo $res[$i]['nome']; 
				}
			}else if($abelha){
				$aux = polinizacao($abelha);
				
				if($aux == 0)
					return 0;

				for ($i=0; $i < sizeof($aux); $i++) { 
					$sql_code = "SELECT nome,idIMagem FROM flor WHERE id=".$aux[$i];
					$res = $mysqli->query($sql_code);
					$res = $res->fetchAll();
					$result[$i] = $res[0];
					//echo $res[$i]['nome']; 
				}
				
				
			}else{
				$sql_code = "SELECT nome,idIMagem FROM flor";

				$result = $mysqli->query($sql_code);
				$result = $result->fetchAll();

			}
			$j = 0;
			for ($i=0; $i < 3; $i++) { 
				echo "<tr>";
					for ($k=0; $k < 4; $k++) { 
						echo "<td align='center'>";
							if($j<sizeof($result)){
								$imag = $result[$j]['idIMagem'];
							
								$sql_code = "SELECT arquivo FROM imagem WHERE id = '$imag'";

								$resultImage = $mysqli->query($sql_code);
								$resultImage = $resultImage->fetchAll();
								$srcImage = $resultImage[0]['arquivo'];
								echo "<img src='pictures/".$srcImage."' class='img-circle imgFlor' >";
								echo "<p class='textoNomeFlor'>".$result[$j]['nome']."</p>";
								$j+=1;
							}
						echo "</td>";
					}

				echo "</tr>";
			}
}
function polinizacao($abelha){
	/* 
		Esta função retorna o vetor contendo os idFLor da Abelha selecionada
	*/

	require_once 'conexao/Connection.php';
	require_once 'conexao/PoolConnection.php';

		$con1 = new Connection();
		$con2 = new Connection();
		$pooll = new PoolConnection();
	    $pooll->addConnection($con1);
	    $mysqli = $pooll->getConnection();

		$sql_code = "SELECT idFlor FROM polinizacao WHERE idAbelha = '$abelha'";	
		$result0 = $mysqli->query($sql_code);
		$result0 = $result0->fetchAll();

		for ($i=0; $i < sizeof($result0) ; $i++) { 
			$resultado[$i] = $result0[$i]['idFlor'];
		}
		 if(sizeof($result0) == 0)
		 	return 0;
		return $resultado;  


}
function florescimento($meses){
	/*
		Esta função retorna o vetor contendo os idFLor dos meses selecionados, ela ficou complexa pois não soube utilizar sabia utilizar join, acredito que isso dificulto na consulto, devido a isso tive que impletar minha logica na programação e não no sql.

	*/

	require_once 'conexao/Connection.php';
	require_once 'conexao/PoolConnection.php';

		$con1 = new Connection();
		$con2 = new Connection();
		$pooll = new PoolConnection();
	    $pooll->addConnection($con1);
	    $mysqli = $pooll->getConnection();
	    $pooll->addConnection($con2);
	    $mysql = $pooll->getConnection();
		
		
		if(sizeof($meses)>1){
			for ($i=0; $i < sizeof($meses) -1 ; $i++) { 

				if($i == 0){
					/* Neste if ela faz uma comparação da consulta dos idFlor do primeiro Mes e do segundo, e gera um  vetor aux que contem apenas o idFlor que estão nas duas consulta, esse aux é utilizado para comparar com a consulta dos proximos meses no else desse if, ela utiliza de varios return caso a consulta nao retorne nda  ou a comparacao com aux tbm nao retorne nda*/
					$sql_code = "SELECT idFlor FROM florescimento WHERE idMes = '$meses[0]'";	
					$result0 = $mysqli->query($sql_code);
					$result0 = $result0->fetchAll();
					if($result0 == null)
						return 0;


					$j = 1;
					$sql_code = $sql_code = "SELECT idFlor FROM florescimento WHERE idMes = '$meses[1]'";	
					$result1 = $mysqli->query($sql_code);
					$result1 = $result1->fetchAll();
					if($result1 == null)
						return 0;

					$a = 0;

					for ($k=0; $k < sizeof($result0) ; $k++) { 
						for ($l=0; $l < sizeof($result1) ; $l++) { 
							if($result0[$k]['idFlor'] == $result1[$l]['idFlor']){
								$aux[$a] = $result0[$k]['idFlor'];
								$a+=1;
							}
						}	
					}	
					$i = $j;

				}else{
					if(@$aux == null)
						return 0;
					$sql_code = $sql_code = "SELECT idFlor FROM florescimento WHERE idMes = '$meses[$i]'";
					//echo $sql_code."<br";

					try{
						$result = $mysql->query($sql_code);
					}catch (Exception $e) {
					    echo 'Exceção capturada: ',  $e->getMessage(), "\n";
					    return 0;
					}
					$result = $result->fetchAll();	


					$cont = 0;
					for ($k=0; ($k < sizeof($aux)); $k++) { 
						for ($l=0; $l < sizeof($result); $l++) { 
							if($aux[$k] == $result[$l]){
								$cont++;
							}
						}
						if($cont == 0){
							$aux[$k] =0;
						}
					}
				}
			}
			$r = 0;
			if(@$aux == null)
				return 0;
					
			for ($k=0; $k < sizeof($aux); $k++) { 
				if($aux[$k]){
					$retorna[$r] = $aux[$k];
					//echo $aux[$k]." ";
					$r = $r +1;	
				}
			}
			if (@$retorna == null) {
				return 0;
			}
		}else{
			/* Caso so um mes seja selecionado a consulta em feita sem nenhuma comparação */

			$sql_code= "SELECT idFlor FROM florescimento WHERE idMes = '$meses[0]'";
			$result = $mysqli->query($sql_code);
			$result = $result->fetchAll();
			if($result == null)
				return 0;
			for ($i=0; $i < sizeof($result); $i++) { 
				$retorna[$i] = $result[$i]['idFlor'];
			}
		}
		
		return $retorna;		
}
?>
