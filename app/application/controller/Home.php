<?php

namespace application\controller;

use core\View;

class Home 
{
    public function index()
    {
    	$dados = array(
    		'title'	=>	'Home - Crud'
		);
		
        new View($dados);
    }
}