<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Presupuesto;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PresupuestoRepository;
use Exception;
use Psr\Log\LoggerInterface;

class PresupuestoDataPersister implements ContextAwareDataPersisterInterface
{
    private $em;
    /**
     * presupuestoRepository
     *
     * @var PresupuestoRepository
     */
    private $presupuestoRepository;

    private $logger;

    public function __construct(EntityManagerInterface $em, PresupuestoRepository $presupuestoRepository, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->presupuestoRepository = $presupuestoRepository;
        $this->logger = $logger;
    }


    public function supports($data, array $context = []): bool
    {
        return $data instanceof Presupuesto;
    }

    /**
     * persist
     *
     * @param  Presupuesto $data
     */
    public function persist($data, array $context = [])
    {
        $this->em->beginTransaction();
        try{
            if ($context["item_operation_name"] ?? null === 'PUT'){
                $prevPresupuesto = $this->em->getUnitOfWork()->getOriginalEntityData($data);

                $prevTotal = $prevPresupuesto['porgastot'];
                $data->setPresactu($data->getReniddotot() + $data->getPorgastot());

                $this->em->persist($data);
                $this->em->flush();


                $totalDiff =  $data->getPorgastot() -$prevTotal;

                $partida = $data->getPartida();
                $padre = $partida->getPadre();
                while ($padre){
                    $partida = $padre;
                    $newPresupuesto = $this->presupuestoRepository->findOneBy([
                        'obra' => $data->getObra(),
                        'partida' => $partida
                    ]);

                    $newPresupuesto->setPorgastot($newPresupuesto->getPorgastot() + $totalDiff);
                    $newPresupuesto->setPresactu($newPresupuesto->getReniddotot() + $newPresupuesto->getPorgastot());
                    $this->em->persist($newPresupuesto);
                    $this->em->flush();

                    $padre = $partida->getPadre();
                }

            }
            if ($context["collection_operation_name"] ?? null === 'POST'){
                $data->setPorgascan($data->getCantini());
                $data->setPorgascost($data->getCostoini());
                $data->setPorgastot($data->getTotalini());
                $data->setPresactu($data->getTotalini());
                $this->em->persist($data);
                $this->em->flush();

                $partida = $data->getPartida();
                $padre = $partida->getPadre();

                while ($padre){
                    $partida = $padre;
                    $newPresupuesto = $this->presupuestoRepository->findOneBy([
                        'obra' => $data->getObra(),
                        'partida' => $partida
                    ]);

                    if (!$newPresupuesto){
                        $newPresupuesto = new Presupuesto;
                        $newPresupuesto->setObra($data->getObra());
                        $newPresupuesto->setPartida($partida);
                        $newPresupuesto->setTotalini(0);
                        $newPresupuesto->setReniddotot(0);
                        $newPresupuesto->setPorgastot(0);
                        $newPresupuesto->setPresactu(0);
                    }

                    $newPresupuesto->setTotalini($newPresupuesto->getTotalini() + $data->getTotalini());
                    $newPresupuesto->setReniddotot($newPresupuesto->getReniddotot() + $data->getReniddotot());
                    $newPresupuesto->setPorgastot($newPresupuesto->getPorgastot() + $data->getPorgastot());
                    $newPresupuesto->setPresactu($newPresupuesto->getPresactu() + $data->getPresactu());

                    $this->em->persist($newPresupuesto);
                    $this->em->flush();

                    $padre = $partida->getPadre();
                }

            }
            $this->em->commit();
        } catch (Exception $e) {
            $this->em->rollback();
            return json_encode($e);
        }

    }

    public function remove($data, array $context = [])
    {
        throw new Exception('No se puede eliminar el presupuesto');
    }
}
