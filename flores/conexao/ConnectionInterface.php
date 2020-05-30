<?php

interface ConnectionInterface 
{
    public function attach();
    
    public function detach();
    
    public function busy();    
}
