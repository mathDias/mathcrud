<?php

namespace application\model;

use core\AbstractModel;

class Contato extends AbstractModel
{
	protected $tabela  = 'contato';
    protected $primary = 'contato_id';
    protected $dados = array(
        'contato_id'   => null,
        'nome' => null,
        'email'=> null,
        'celular'=> null,
        'telefone'=> null
    );

    protected $contatoEndereco;

    public function __construct()
    {
        parent::__construct();
    }

    public function __toString()
    {
        return __CLASS__;
    }

    public function getPrimaryKey()
    {
        return $this->primary;
    }
    
    public function save($dados)
    {
        $this->dados = $dados;
        
        if (isset($this->dados[$this->primary])) {
            return $this->banco->update($this);
        } else {
            return $this->banco->insert($this);
        }
    }
    
    public function find($id)
    {
        $this->setContato_id($id);
        
        return $this->banco->find($this);
    }
    
    public function buscarTodos($busca=null)
    {
        return $this->banco->findAll($this, $busca);
    }

    public function getEndereco(){
        $endereco = new ContatoEndereco();
        $dados = $endereco->buscarTodos(" WHERE contato_id = ".$this->getContato_id());

        if($dados[0])
            return $dados[0];
        else
            return false;

    }
    
    public function excluir($id)
    {
        $this->setContato_id($id);
        return $this->banco->delete($this);
    }
}