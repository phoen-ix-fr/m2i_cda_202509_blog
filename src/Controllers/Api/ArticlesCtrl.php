<?php

namespace M2i\Blog\Controllers\Api;

class ArticlesCtrl
{
    private function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function home()
    {
        switch($this->getRequestMethod())
        {
            case 'GET':
                $this->getAll();
                break;

            case 'POST':
                $this->create();
                break;

            case 'PUT':
                $this->update();
                break;

            case 'DELETE':
                $this->delete();
                break;
            
        }
    }



    /**
     * GET api/articles/test
     * Méthode de test pour l'appel API REST
     */
    function test()
    {
        var_dump($_SERVER);

        /*
        header('Content-Type: application/json; charset=utf-8');

        $json = json_encode([
            'success'   => true,
            'data'      => [],
            'message'   => "Mon API est fonctionnelle"
        ]);

        echo $json;
        */
    }

    /**
     * GET api/articles
     * Liste tous les articles du blog
     */
    function getAll()
    {
        echo "Get ALL (Methode GET)";
    }

    /**
     * GET api/articles?id=1
     * Récupérer un article en particulier par son ID
     */
    function getOne()
    {

    }

    /**
     * POST api/articles
     * Créer un nouvel article en base de données
     */
    function create()
    {
        $input = file_get_contents('php://input');
        var_dump($input);

        echo "Create (Methode POST)";

    }

    /**
     * PUT api/articles
     * Modifie un article en base de données
     */
    function update()
    {
        $input = file_get_contents('php://input');
        var_dump($input);

        echo "Update (Methode PUT)";
    }

    /**
     * DELETE api/articles
     * Supprime un article en base de données
     */
    function delete()
    {
        $input = file_get_contents('php://input');
        var_dump($input);

        echo "Delete (Methode DELETE)";
    }
}