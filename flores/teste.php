<?php
require_once 'conexao/Connection.php';
	require_once 'conexao/PoolConnection.php';

	$con1 = new Connection();
	$pooll = new PoolConnection();
    $pooll->addConnection($con1);
	$mysqli = $pooll->getConnection();



	
	$abelhas = $_POST['abelhas'];
	
	for($i = 0; $i <sizeof($abelhas); $i++){
		echo $abelhas[$i];
		$sql_code = "SELECT id FROM abelha WHERE nome = '$abelhas[$i]';";
		foreach ($mysqli->query($sql_code) as $row) {
		    $idAbelhas[$i] =  $row['id'];
		    echo $idAbelhas[$i]."  ddas";
		}	
	}

?>
