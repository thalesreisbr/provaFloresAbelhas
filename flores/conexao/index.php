<?php
require_once './Connection.php';
require_once './PoolConnection.php';

try{
    $con1 = new Connection();
    $con2 = new Connection();
    
    $pooll = new PoolConnection();
    $pooll->addConnection($con1);
    $pooll->addConnection($con2);


    echo '<pre>';
    echo '<h2>Tentando pegar 1º conexão do Pool e buscando todos as empresas cadastradas</h2>';
    $connection1 = $pooll->getConnection();    
    $result = $connection1->query('SELECT ID FROM companies', Connection::FETCH_OBJ);

    foreach($result as $row){
        print_r($row);
    }

    echo '<h2>Tentando pegar 2º conexão do Pool e buscando todos as empresas cadastradas</h2>';
    $connection2 = $pooll->getConnection();
    $result2 = $connection2->query('SELECT * FROM companies', Connection::FETCH_OBJ);    
    
    foreach($result2 as $row){
        print_r($row);
    }
    
    echo '<h2>Tentando pegar 3º conexão do Pool e buscando todos as empresas cadastradas</h2>';
    $connection3 = $pooll->getConnection();
    $result2 = $connection3->query('SELECT * FROM companies', Connection::FETCH_OBJ);
    
    foreach($result3 as $row){
        print_r($row);
    }    

} catch (Exception $e){
    echo $e->getMessage();
}