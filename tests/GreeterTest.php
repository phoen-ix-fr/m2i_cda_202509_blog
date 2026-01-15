<?php 

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

// Lancer la commande ci-dessous pour exécuter le test :
// php ./vendor/phpunit/phpunit/phpunit tests/GreeterTest.php
final class GreeterTest extends TestCase
{
    public function testGreetsWithName(): void
    {
        $greeting = 'Hello, Alice!';

        $this->assertSame('Hello, Alice!', $greeting);
    }
}