<?php
require_once("dao/clienteDao.php");

class cliente{
    
    public $idCliente = 0;
    public $nomeCliente = "";
    public $emailCliente = "";
    public $senhaCliente = "";
    
    public function validaCliente($email){
        $cliente = obtemCliente($email); 
        return $cliente;
    }
    
}



?>