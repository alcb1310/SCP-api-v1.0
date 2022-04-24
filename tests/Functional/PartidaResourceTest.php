<?php
namespace App\Tests\Functional;

use App\Entity\Partida;
use App\Test\CustomApiTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class PartidaResourceTest extends CustomApiTestCase
{
    use ReloadDatabaseTrait;

    public function testCreatePartida()
    {
        $client = self::createClient();

        $client->request('POST', '/api/partidas', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [],
        ]);
        $this->assertResponseStatusCodeSame(401);

        $this->createUserAndLogin($client, 'testuser', 'foopassword', 'Test User');

        $client->request('POST', '/api/partidas', [
            'json' => [],
        ]);

        $this->assertResponseStatusCodeSame(422);

        $client->request('POST', '/api/partidas', [
            'json' => [],
        ]);

        $this->assertResponseStatusCodeSame(422);

        $client->request('POST', '/api/partidas', [
            'json' => [
                'codigo' => '500',
                'nombre' => 'COSTO',
                'acumula' => true,
                'nivel' => 1
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testUpdatePartida()
    {
        $client = self::createClient();
        $user = $this->createUser($client, 'testuser', 'foopassword', 'Test User');

        $em = $this->getEntityManager();

        $partida = new Partida;
        $partida->setCodigo('100');
        $partida->setAcumula(true);
        $partida->setNivel(1);
        $partida->setNombre('Gastos terreno');

        $em->persist($partida);
        $em->flush();

        $client->request('PUT', '/api/partidas/'.$partida->getId(), [
            'json' => [
                'nombre' => 'COSTO'
            ],
        ]);

        $this->assertResponseStatusCodeSame(401);

        $this->logIn($client, 'testuser', 'foopassword');

        $client->request('PUT', '/api/partidas/'.$partida->getId(), [
            'json' => [
                'nombre' => 'COSTO'
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);


    }
}
