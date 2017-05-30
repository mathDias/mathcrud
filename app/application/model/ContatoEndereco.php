<?php

namespace application\model;

use core\AbstractModel;

class ContatoEndereco extends AbstractModel
{
	protected $tabela  = 'contato_endereco';
    protected $primary = 'endereco_id';
    protected $dados = array(
        'endereco_id'   => null,
        'contato_id'   => null,
        'cep' => null,
        'logradouro'=> null,
        'numero'=> null,
        'complemento'=> null,
        'bairro'=> null,
        'cidade'=> null,
        'estado'=> null
    );

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
        $this->setEndereco_id($id);
        
        return $this->banco->find($this);
    }
    
    public function buscarTodos($busca=null)
    {
        return $this->banco->findAll($this, $busca);
    }
    
    public function excluir($id)
    {
        $this->setEndereco_id($id);
        return $this->banco->delete($this);
    }
}