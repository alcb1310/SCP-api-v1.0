<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PresupuestoEndPointCustomMethods extends AbstractController
{
    #[Route('/api/presupuestos/cierre', name:'app-cierre')]
    public function setCierreMes(): Response
    {
        return $this->json('', 205);
    }
}
