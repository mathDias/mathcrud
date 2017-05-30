<?php

namespace core;

class Datamapper
{
    public function insert($obj)
    {
        

        foreach ($obj->getDados() as $chave => $valor) {
            $campos[] = $chave;
            $valores[]  = $valor;
            $holders[]= '?';
        }
        
      
        $campos = implode(',', $campos);
         
        $holders= implode(',', $holders);
       
        $sql = "INSERT INTO {$obj->getTabela()}($campos) VALUES($holders)";
        

        $state = $this->conexao->prepare($sql);
        
        if($state->execute($valores)){
            return $this->conexao->lastInsertId();
        }else{
            return false;
        }
    }
    
    public function update($obj)
    {

        foreach ($obj->getDados() as $chave => $valor) {
            $campos[] = "$chave=?";
            $valores[]  = $valor;
        }
        
        $campos = implode(',', $campos);
        
        
        $sql = "UPDATE {$obj->getTabela()} SET $campos WHERE {$obj->getPrimaryKey()} = ?";
        $state = $this->conexao->prepare($sql);

        
        $func = "get".$obj->getPrimaryKey();
        array_push($valores, $obj->$func());
        
        return $state->execute($valores);
    }
    
    public function find($obj)
    {
        
        $sql = "SELECT * FROM {$obj->getTabela()} WHERE {$obj->getPrimaryKey()} = ?";

        $func = "get".$obj->getPrimaryKey();

        $state = $this->conexao->prepare($sql);
        $state->execute(array($obj->$func()));
        
       
        
        return $state->fetchObject((string) $obj);
    }
    
    public function findAll($obj, $busca=null)
    {
        $sql = "SELECT * FROM {$obj->getTabela()}";
        
        if (!is_null($busca)) {
            $sql .= $busca;
        }
        #die($sql);
        $state = $this->conexao->query($sql);
        
        return $state->fetchAll(\PDO::FETCH_CLASS, (string) $obj);
    }
    
    public function delete($obj)
    {
        $func = "get".$obj->getPrimaryKey();
        $sql = "DELETE FROM {$obj->getTabela()} WHERE {$obj->getPrimaryKey()} = ?";
        $state = $this->conexao->prepare($sql);
        return $state->execute(array($obj->$func()));
    }
}