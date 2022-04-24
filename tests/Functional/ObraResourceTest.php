<?php

namespace App\Tests\Functional;

use App\Entity\Obra;
use App\Test\CustomApiTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class ObraResourceTest extends CustomApiTestCase
{
    use ReloadDatabaseTrait; // * Cleans the database

    public function testGetObraInfo(): void
    {
        $client = self::createClient();
        $em = $this->getEntityManager();

        $obra = new Obra();
        $obra->setNombre('Test');
        $obra->setCasas(10);
        $obra->setActivo(true);

        $em->persist($obra);
        $em->flush();

        $iri = '/api/obras/'.$obra->getId();

        $client->request('GET', $iri, [
            'headers' => ['Content-Type' => 'application/json']
        ]);


        $this->assertResponseStatusCodeSame(401, 'No se puede consultar las obras si no se esta autorizado');

        $this->createUserAndLogin($client, 'testuser', 'userpassword', 'Test User');

        $client->request('GET', $iri, [
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $this->assertResponseStatusCodeSame(200);

    }

    public function testCreateObra()
    {
        $client = self::createClient();

        $obra = [
            'nombre' => 'Obra Test',
            'casas' => 10,
            'activo' => true
        ];
        $client->request('POST', '/api/obras', [
            'json' => $obra
        ]);

        $this->assertResponseStatusCodeSame(401);
        $this->createUserAndLogin($client, 'testuser', 'userpassword', 'Test User');
        $client->request('POST', '/api/obras', [
            'json' => $obra
        ]);

        $this->assertResponseStatusCodeSame(201);

        $obra = [
            'nombre' => 'Test',
            'casas' => 10,
            'activo' => true
        ];
        $client->request('POST', '/api/obras', [
            'json' => $obra
        ]);

        $this->assertResponseStatusCodeSame(422);

        $obra = [
        ];
        $client->request('POST', '/api/obras', [
            'json' => $obra
        ]);

        $this->assertResponseStatusCodeSame(422);

        $obra = [
            'nombre' => 'Obra Test',
            'casas' => 10,
            'activo' => true
        ];
        $client->request('POST', '/api/obras', [
            'json' => $obra
        ]);
        $this->assertResponseStatusCodeSame(422);

    }
}
