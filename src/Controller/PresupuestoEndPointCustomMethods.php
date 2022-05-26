<?php

namespace App\Controller;

use App\Entity\ActualHistorico;
use App\Entity\Control;
use App\Repository\ActualRepository;
use App\Repository\ObraRepository;
use App\Repository\PresupuestoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PresupuestoEndPointCustomMethods extends AbstractController
{
    #[Route('/presupuestos/cierre', name:'app-cierre', methods:'POST')]
    public function setCierreMes(
        Request $request, PresupuestoRepository $presupuestoRepository,
        EntityManagerInterface $em, ObraRepository $obraRepository,
        ActualRepository $actualRepository): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER');

        // $fecha = $request->request->get("fecha");
        // $obra = $request->request->get('obra');

        $params = json_decode($request->getContent(), true);

        $fecha = null;
        $obraId = null;
        if (array_key_exists('fecha', $params)){
            $fecha = $params['fecha'];
        }
        if (array_key_exists( 'obra', $params)){
            $obraId = $params['obra'];
        }

        $errorArray = $this->validateData($fecha, $obraId);

        if (count($errorArray) > 0){
            return $this->json($errorArray, 412);
        }

        $obra = $obraRepository->findOneBy(['id' => $obraId]);

        $presupuestos = $presupuestoRepository->findBy([
            'obra' => $obra,
        ]);

        $actuals = $actualRepository->findBy([
            'obra' => $obra
        ]);

        $em->beginTransaction();

        try{
            foreach ($presupuestos as $presupuesto){
                $control = new Control;
                $control->setFecha(new \DateTime($fecha));
                $control->setObra($obra);
                $control->setPartida($presupuesto->getPartida());
                $control->setCantini($presupuesto->getCantini());
                $control->setCostoini($presupuesto->getCostoini());
                $control->setTotalini($presupuesto->getTotalini());
                $control->setRendidocant($presupuesto->getRendidocant());
                $control->setRendidotot($presupuesto->getReniddotot());
                $control->setPorgascan($presupuesto->getPorgascan());
                $control->setPorgascost($presupuesto->getPorgascost());
                $control->setPorgastot($presupuesto->getPorgastot());
                $control->setPresactu($presupuesto->getPresactu());

                $em->persist($control);
                $em->flush();
            }

            foreach($actuals as $actual){
                $actualHistorico = new ActualHistorico;
                $actualHistorico->setFecha(new \DateTime($fecha));
                $actualHistorico->setObra($obra);
                $actualHistorico->setPartida($actual->getPartida());
                $actualHistorico->setCasas($actual->getCasas());
                $actualHistorico->setTotal($actual->getTotal());

                $em->persist($actualHistorico);
                $em->flush();
            }

            $em->commit();
            $returnObject = ['success' => true];

            return $this->json($returnObject, 200);
        } catch (\Exception $e){
            $em->rollback();
            return $this->json('Error al procesar', 422);
        }
    }

    private function validateData($fecha, $obra): array
    {
        $return = array();

        // fecha parameter in query is required for this process
        if (!$fecha){
            $return['error-fecha'] = 'Ingrese una fecha para procesar';
        } else {
            $d = \DateTime::createFromFormat('Y-m-d', $fecha);

            // Validate the user sends a correct date format
            if (!($d && $d->format('Y-m-d') === $fecha)){
                $return['error-fecha'] = 'Fecha ingresada debe ser en formato yyyy-mm-dd';
            }
        }

        if(!$obra){
            $return['error-obra'] = 'Ingrese una obra a procesar';
        } else  {
            if (!intval($obra)){
                $return['error-obra'] = "Ingrese el codigo de la obra";
            }
        }

        return $return;
    }
}
