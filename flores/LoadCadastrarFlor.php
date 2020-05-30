<?php
	require_once 'conexao/Connection.php';
	require_once 'conexao/PoolConnection.php';

	$con1 = new Connection();
	$pooll = new PoolConnection();
    $pooll->addConnection($con1);
	$mysqli = $pooll->getConnection();
	

	# Abaixo faz se uma manipulação da string apara encontrar a extensao, de imagem tem JPEG ou JPG, por isso a necessidade
	$i =-4;
	if(substr($_FILES['imagem']['name'], $i)[0]!='.')
		$i -=1;
	$extensao = strtolower(substr($_FILES['imagem']['name'], $i));
	# muda-se o nome com a função md5 para não haver nome de imagens iguais na pasta pictures
	$novo_nome = md5(time()).$extensao;
	$diretorio = "pictures/";

	move_uploaded_file($_FILES['imagem']['tmp_name'],$diretorio.$novo_nome);

	#insere na tabela o nome da imagem e move ela para pasta pictures  e pega o id da insercao dela, pois é chave estrangeira de flor
	if(isset($_FILES['imagem'])){
		$sql_code = "INSERT INTO imagem (arquivo,data) VALUES('$novo_nome', NOW());";
	}
	
	if($mysqli->query($sql_code)){
		$sql_code = "SELECT id FROM imagem WHERE arquivo = '$novo_nome';";
		foreach ($mysqli->query($sql_code) as $row) {
		    $idImagem =  $row['id'];
		}
	}else
		echo "Errado Insersacao da imagem<br>";

	$nome = $_POST['nome'];
	$especie = $_POST['especie'];
	$descricao = $_POST['descricao'];
	
	
	
	$sql_code = "INSERT INTO flor (nome,especie,descricao,idImagem) VALUES('$nome','$especie','descricao','$idImagem');";

	if($mysqli->query($sql_code)){
		echo "ok<br>";
	}else
		echo "errado";


	#Como foi feito o envio de dados a partir do hidden, foi inizializados dos hidden com 0 e apenas os que que os meses selecionado foi trocado o valor de 0 
	$j = 0;
	for ($i=1; $i < 13; $i++) { 
		if($_POST[$i]){
			$meses[$j] =  $_POST[$i];
			$j+=1;
		}
	}
	#Nao tinhamos o valor do id da flor que estamos inserindo
	$sql_code = "SELECT id FROM flor WHERE especie = '$especie';";
	foreach ($mysqli->query($sql_code) as $row) {
		$idFlor =  $row['id'];
	}


	for ($i=0; $i < $j; $i++) { 
		$sql_code = "INSERT INTO florescimento (idMes,idFlor) VALUES('$meses[$i]','$idFlor')";
		echo $sql_code."<br>";
		$mysqli->query($sql_code);
	}
	$abelhas = $_POST['abelhas'];
	for ($i=0; $i < sizeof($abelhas); $i++) { 
		echo $abelhas[$i];

	}
		//echo "<br> Tamanho de abelhas".sizeof($abelhas);
	
	for($i = 0; $i <sizeof($abelhas); $i++){
		$sql_code = "SELECT id FROM abelha WHERE nome = '$abelhas[$i]';";
		foreach ($mysqli->query($sql_code) as $row) {
		    $idAbelhas[$i] =  $row['id'];
		   
		  } 
	}
	
	for ($i=0; $i < sizeof($idAbelhas); $i++) { 
		$sql_code = "INSERT INTO polinizacao (idAbelha,idFlor) VALUES('$idAbelhas[$i]','$idFlor')";
		$mysqli->query($sql_code);
	}
?>
