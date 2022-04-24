<?php
namespace App\Test;

use App\Entity\User;
// use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Doctrine\ORM\EntityManagerInterface;

class CustomApiTestCase extends ApiTestCase
{
    protected function createUser(Client $client, string $username, string $password, string $nombre): string
    {
        $data = $client->request('POST', '/api/users', [
            'json'=> [
                'username' => $username,
                'password' => $password,
                'nombre' => $nombre
            ]
        ]);

        return $data->toArray()['@id'];
    }

    protected function logIn(Client $client, string $username, string $password)
    {
        $client->request('POST', '/login', [
            'json' => [
                'username' => $username,
                'password' => $password
            ],
        ]);
        $this->assertResponseStatusCodeSame(204);
    }

    protected function createUserAndLogin(Client $client, string $username, string $password, string $nombre): string
    {
        $user = $this->createUser($client, $username, $password, $nombre);
        $this->logIn($client, $username, $password);
        return $user;
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        $container = self::$kernel->getContainer();

        return $container->get('doctrine')->getManager();
    }

}