<?php

namespace core;

class Banco extends Datamapper
{

	private $host = "#"; // alterar host
	private $dbname = "#"; //alterar nome banco
	private $user = "#"; // usuario
	private $senha = "#"; // alterar

    public function __construct()
    {
    	if($this->host == "#")
    		die("Configurações inválidas em app/core/Banco.php");

        $this->conexao = new \PDO(
            "mysql:host={$this->host};dbname={$this->dbname}",
            "{$this->user}",
            "{$this->senha}"
        );
        $this->conexao->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
}