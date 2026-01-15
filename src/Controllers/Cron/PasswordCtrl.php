<?php

namespace M2i\Blog\Controllers\Cron;

use M2i\Blog\Entities\User;
use M2i\Blog\Models\UserModel;

class PasswordCtrl
{
    protected function getHostRequest(): string
    {
        return $_SERVER['HTTP_HOST'];
    }

    public function home()
    {
        if($this->getHostRequest() !== $_ENV['CRON_ALLOWED_HOST'])
        {
            exit;
        }

        $objUserModel = new UserModel();

        // Récupérer les utilisateurs dont les mots de passe ne sont pas hashé
        $arrUsers = $objUserModel->getUnhashedPassword();

        // Hasher les mots de passe en base
        foreach($arrUsers as $arrUser)
        {
            $objUser = new User();
            $objUser->hydrate($arrUser);

            $objUser->setPwd(password_hash($objUser->getPwd(), PASSWORD_DEFAULT));

            if($objUserModel->editUser($objUser))
            {
                echo "User " . $objUser->getId() . " modifié avec succès";
            }
            else
            {
                echo "Une erreur est survenue lors de la modification du user " . $objUser->getId();
            }
        }
    }
}