<?php

namespace M2i\Blog\Controllers\Cron;

use M2i\Blog\Entities\User;
use M2i\Blog\Models\UserModel;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class PasswordCtrl
{
    protected function getHostRequest(): string
    {
        return $_SERVER['HTTP_HOST'];
    }

    public function home()
    {
        $objLogger = new Logger('cron');

        $objStreamHandlerInfo   = new StreamHandler('logs/cron.log', Level::Info);
        $objStreamHandlerError  = new StreamHandler('logs/cron_error.log', Level::Error);

        $objLogger->pushHandler($objStreamHandlerInfo);
        $objLogger->pushHandler($objStreamHandlerError);

        if($this->getHostRequest() !== $_ENV['CRON_ALLOWED_HOST'])
        {
            $objLogger->info("Tentative d'appel CRON depuis un hôte non autorisé");
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
                $objLogger->info("User " . $objUser->getId() . " modifié avec succès");
            }
            else
            {
                $objLogger->error("Une erreur est survenue lors de la modification du user " . $objUser->getId());
            }
        }
    }
}