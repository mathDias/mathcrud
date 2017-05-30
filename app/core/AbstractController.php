<?php
namespace core;

abstract class AbstractController
{
    protected function getModel($model)
    {
        if ($model) {
            $path = "application\\model\\{$model}";
            
            return new $path();
        }
    }
}