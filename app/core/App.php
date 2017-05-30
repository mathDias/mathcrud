<?php

namespace core;
class App
{
    protected $controller, $param;
    protected $metodo = 'index';
    
    public function __construct()
    {
        
        if($_GET['url'])
            list($controller,$action,$id) = explode("/",$_GET['url']);

        $controller = isset($controller) ? $controller : 'Home';
        $action     = isset($action) ? $action : 'index';


        $this->controller = "application\\controller\\{$controller}";

       

        if (class_exists($this->controller)) {
            $this->controller = new $this->controller();
            
            if (!method_exists($this->controller, $action)) {
                die("Ação não encontrada");
            }

        } else {
            die("Controladora não encontrada");
        }
        
        $this->controller->$action($id);
    }
}