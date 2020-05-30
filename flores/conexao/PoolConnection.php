<?php
require_once 'ConnectionInterface.php';

class PoolConnection
{
    private $pool = array();
    
    public function addConnection(ConnectionInterface $obj)
    {
        array_push($this->pool, array(
            'connection' => $obj,
            'datetime' => new DateTime()));
    }
    
    public function getConnection()
    {
        foreach ($this->pool as &$object )
        {
            if($object['connection']->busy() === false){
                $object['connection']->attach();
                return $object['connection'];
            }
        }
        
        throw new Exception('Nao ha nenhuma conexao disponivel');
    }
}