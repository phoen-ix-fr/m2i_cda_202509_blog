<?php

namespace M2i\Blog\Controllers\Api;

use M2i\Blog\Traits\CanResponse;
use M2i\Blog\Traits\Requestable;

abstract class MotherCtrl
{
    use Requestable, CanResponse;

    public function home()
    {
        switch($this->getRequestMethod())
        {
            case 'GET':

                // Vérifie si un id est présent dans l'URL
                if($_GET['id']??false) {
                    $this->getOne();
                }
                else {
                    $this->getAll();
                }

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

    protected abstract function getOne();

    protected abstract function getAll();

    protected abstract function create();

    protected abstract function update();

    protected abstract function delete();
}