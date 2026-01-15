<?php 

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

// Lancer la commande ci-dessous pour exécuter le test :
// php ./vendor/phpunit/phpunit/phpunit tests/GreeterTest.php
final class ArticlesCtrlTest extends TestCase
{
    public function testListArticles(): void
    {
        // Curl permet de lancer des requêtes HTTP depuis du code PHP (comme on le ferait avec Postman)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/m2i_blog/api/articles");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec($ch);

        // Vérifie si le résultat renvoyé par l'API est bien un format JSON valide
        $this->assertJson($res);
    }
}