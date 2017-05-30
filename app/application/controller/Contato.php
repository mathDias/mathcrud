<?php

namespace application\controller;
use core\AbstractController;
use core\View;

class Contato extends AbstractController
{

    protected $contatoModel;
    protected $contatoEnderecoModel;


    public function __construct()
    {
        $this->contatoModel = $this->getModel('Contato');
        $this->contatoEnderecoModel = $this->getModel('ContatoEndereco');
    }

    public function index()
    {
    	$dados = array(
    		'title'	=>	'Contatos'
		);

        $dados['contatos'] = $this->contatoModel->buscarTodos();
        new View($dados,'contato','index');
    }

    public function add()
    {

    	if($_POST){
            $dadosCadastro = array(
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'celular' => $_POST['celular'],
                'telefone' => $_POST['telefone'],
            );

            $dadosEndereco = array(
                'contato_id'   => null,
                'cep' => $_POST['cep'],
                'logradouro'=> $_POST['logradouro'],
                'numero'=> $_POST['numero'],
                'complemento'=> $_POST['complemento'],
                'bairro'=> $_POST['bairro'],
                'cidade'=> $_POST['cidade'],
                'estado'=> $_POST['estado']
            );

            if ($id = $this->contatoModel->save($dadosCadastro)) {

                $dadosEndereco['contato_id'] = $id;
                $idEndereco = $this->contatoEnderecoModel->save($dadosEndereco);

                exit(json_encode(array("success" => true,'msg' => 'Dados cadastrados com sucesso')));

            } else {
                exit(json_encode(array("success" => false,'msg' => 'Erro ao cadastrar dados')));
            }

    	}else{

	    	$dados = array(
	    		'title'	=>	'Cadastro contato'
			);
			
	        new View($dados,'contato','add');
        }

    }

    public function edit($id = null)
    {
	   
    	if($_POST){
    		
            $dadosCadastro = array(
                'contato_id' => $_POST['contato_id'],
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'celular' => $_POST['celular'],
                'telefone' => $_POST['telefone'],
            );

            $dadosEndereco = array(
                'endereco_id'   => null,
                'contato_id'   =>  $_POST['contato_id'],
                'cep' => $_POST['cep'],
                'logradouro'=> $_POST['logradouro'],
                'numero'=> $_POST['numero'],
                'complemento'=> $_POST['complemento'],
                'bairro'=> $_POST['bairro'],
                'cidade'=> $_POST['cidade'],
                'estado'=> $_POST['estado']
            );
            try{
                if($contato = $this->contatoModel->find($_POST['contato_id'])){

                    if($this->contatoModel->save($dadosCadastro)){

                        $endereco = $contato->getEndereco();

                        if($endereco){
                            $dadosEndereco['endereco_id'] = $endereco->getEndereco_id();
                            $this->contatoEnderecoModel->save($dadosEndereco);
                        }
                    }else{
                       throw new Exception("Erro inesperado contate a equipe de suporte"); 
                    }

                    exit(json_encode(array('success' => true, 'msg' => 'Dados alterados com sucesso')));

                }else{
                    throw new Exception("Dados inválidos");
                }

            }catch(Exception $e){
                 exit(json_encode(array('success' => false, 'msg' => $e->getMessage())));
            }
        }else{

            $dados = array(
                'title' =>  'Editar contato'
            );

            if(!$id)
                die("Código inválido");
            else
                $dados['contato'] = $this->contatoModel->find($id);

            new View($dados,'contato','edit');
           
        }
    }

    public function delete($id = null){
        try{
            if($id){
            
                $busca = $this->contatoEnderecoModel->buscarTodos(" WHERE contato_id = ".$id);

                if($busca[0])
                    $this->contatoEnderecoModel->excluir($busca[0]->getEndereco_id());


                $this->contatoModel->excluir($id);

                exit(json_encode(array('success' => true, 'msg' => 'Dados removidos com sucesso')));
            }

        }catch(Exception $e){
             exit(json_encode(array('success' => false, 'msg' => 'Erro ao remover os dados, contate a equipe de suporte')));
        }
    }
}