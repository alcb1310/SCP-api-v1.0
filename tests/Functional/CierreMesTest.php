<?php

namespace App\Tests\Functional;

use App\Entity\Obra;
use App\Entity\Partida;
use App\Entity\Presupuesto;
use App\Test\CustomApiTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class CierreMesTest extends CustomApiTestCase
{
    use ReloadDatabaseTrait;

    public function testCierreMes(){

        $client = self::createClient();
        $user = $this->createUserAndLogin($client, 'andresc', 'fjcl1229', 'Andres');
        $em = $this->getEntityManager();

        $partida = new Partida;
        $partida->setCodigo('100');
        $partida->setNombre('PRUEBA');
        $partida->setAcumula(true);
        $partida->setNivel(1);
        $em->persist($partida);
        $em->flush();

        $partida2 = new Partida;
        $partida2->setCodigo('100.1');
        $partida2->setNombre('PRUEBA 1');
        $partida2->setAcumula(false);
        $partida2->setPadre($partida);
        $partida2->setNivel(2);
        $em->persist($partida2);
        $em->flush();

        $obra = new Obra;
        $obra->setNombre('prueba');
        $obra->setCasas(10);
        $obra->setActivo(true);
        $em->persist($obra);
        $em->flush();

        $presupuesto1 = new Presupuesto;
        $presupuesto1->setObra($obra);
        $presupuesto1->setPartida($partida2);
        $presupuesto1->setTotalini(100);
        $presupuesto1->setRendidocant(0);
        $presupuesto1->setReniddotot(0);
        $presupuesto1->setPorgascan(10);
        $presupuesto1->setPorgascost(10);
        $presupuesto1->setPorgastot(100);
        $presupuesto1->setPresactu(100);
        $em->persist($presupuesto1);
        $em->flush();

        $presupuesto2 = new Presupuesto;
        $presupuesto2->setObra($obra);
        $presupuesto2->setPartida($partida);
        $presupuesto2->setTotalini(100);
        $presupuesto2->setRendidocant(0);
        $presupuesto2->setReniddotot(0);
        $presupuesto2->setPorgastot(100);
        $presupuesto2->setPresactu(100);
        $em->persist($presupuesto2);
        $em->flush();

        $client->request('POST', '/presupuestos/cierre', [
            'json' => [
                'fecha' => '2022-01-31',
                'obra' => $obra->getId()
            ]
        ]);
        $this->assertResponseStatusCodeSame(200);

        $client->request('POST', '/presupuestos/cierre', [
            'json' => [
            ]
        ]);
        $this->assertResponseStatusCodeSame(412);

        $client->request('POST', '/presupuestos/cierre', [
            'json' => [
                'fecha'=> '2022-1-31',
                'obra' => $obra->getId()
            ]
        ]);
        $this->assertResponseStatusCodeSame(412);
    }

}
