<?php

namespace M2i\Blog\Traits;

trait Requestable
{
    protected function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    protected function getInput()
    {
        // Lorsqu'une requête est envoyée avec un corps au format JSON, les données sont
        // récupérables dans le fichier php://input de la manière ci-dessous :
        $input = file_get_contents('php://input');

        if($input) 
        { 
            return json_decode($input, true); 
        }
        elseif(count($_POST) > 0) 
        { 
            return $_POST; 
        }
        else 
        {
            return false;
        }
    }
}