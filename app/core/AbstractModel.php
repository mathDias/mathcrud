<?php

namespace core;

abstract class AbstractModel
{
    public $banco;
    
    public function __construct()
    {
        $this->banco = new Banco();
    }
    
    public function __call($propriedade, $params)
    {
        $prefixo = substr($propriedade, 0, 3);
        $propriedade = strtolower(substr($propriedade, 3));
        
        if (!array_key_exists($propriedade, $this->dados)) {
            throw new \Exception('Propriedade nao encontrada');
        }
        
        switch($prefixo){
            case 'set':
                $this->dados[$propriedade] = $params[0];
            break;
            case 'get':
                return $this->dados[$propriedade];
            break;
            default:
                throw new \Exception('Metodo invalido');
        }
    }
    
    public function getPrimaryKey()
    {
        return $this->primary;
    }
    
    public function getTabela()
    {
        return $this->tabela;
    }
    
    abstract public function __toString();
    
    public function getDados()
    {
        return $this->dados;
    }
    
    public function __set($propriedade, $valor)
    {
        $this->dados[$propriedade] = $valor;
    }
}