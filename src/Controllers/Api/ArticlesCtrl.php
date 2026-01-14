<?php

namespace M2i\Blog\Controllers\Api;

class ArticlesCtrl
{
    function test()
    {
        header('Content-Type: application/json; charset=utf-8');

        $json = json_encode([
            'success'   => true,
            'data'      => [],
            'message'   => "Mon API est fonctionnelle"
        ]);

        echo $json;
    }

    function getAll()
    {


    }
}