<?php
require_once 'ConnectionInterface.php';

class Connection extends PDO implements ConnectionInterface
{
    private $host = "localhost";
    private $database = "flores";
    private $user = "root";
    private $password = "";
    private $driver = "mysql";  
    private $busy = false;
    
    public function __construct() 
    {
        try
        {
            parent::__construct("$this->driver:host=$this->host; dbname=$this->database", 
                $this->user, $this->password);
            
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);            
            $this->exec('SET NAMES utf8');
        }catch (PDOException $e){
            die("Connection Error: " . $e->getMessage());
        }
    }
    
    public function attach()
    {
        $this->busy = true;
    }
    
    public function detach()
    {
        $this->busy = false;
    }
    
    public function busy()
    {
        return $this->busy;
    }
}