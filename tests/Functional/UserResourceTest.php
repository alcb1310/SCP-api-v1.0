<?php

namespace App\Tests\Functional;

use App\Test\CustomApiTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class UserResourceTest extends CustomApiTestCase
{
    use ReloadDatabaseTrait;

    public function testCreateUser()
    {
        $client = self::createClient();

        $client->request('POST', '/api/users', [
            'json'=> [
                'username' => 'testuser',
                'password' => 'foopassword',
                'nombre' => 'testuser'
            ]
        ]);
        $this->assertResponseStatusCodeSame(201);

        $this->logIn($client, 'testuser', 'foopassword');
    }

    public function testUpdateUser()
    {
        $client = self::createClient();
        $iri = $this->createUserAndLogin($client, 'testuser', 'testpassword', 'Test User');
        $client->request('PUT', $iri,[
            'json'=> ['username' => 'newusername']
        ]);
        $this->assertResponseIsSuccessful();

        $this->assertJsonContains(
            ['username' => 'newusername']
        );
    }

}
