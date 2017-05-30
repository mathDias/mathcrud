<?php

namespace core;

class View
{
	public function __construct($dados=null, $controller='home', $action='index')
    {
        require __DIR__ . "/../application/view/layout/topo.phtml";
        
        $tpl = "application/view/$controller/{$action}.phtml";
    	
        if (file_exists(__DIR__ . "/../$tpl")) {
            require __DIR__ . "/../$tpl";
        }
        
        require __DIR__ . "/../application/view/layout/rodape.phtml";
    }
}