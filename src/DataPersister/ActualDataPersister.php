<?php

namespace App\DataPersister;

use App\Entity\Actual;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Exception\PresupuestoNotFoundException;
use App\Repository\ActualRepository;
use App\Repository\PresupuestoRepository;
use Psr\Log\LoggerInterface;

class ActualDataPersister implements ContextAwareDataPersisterInterface
{
    private $em;
    private $presupuestoRepository;
    private $actualRepository;
    private $logger;

    public function __construct(EntityManagerInterface $em, PresupuestoRepository $presupuestoRepository, ActualRepository $actualRepository, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->presupuestoRepository = $presupuestoRepository;
        $this->actualRepository =$actualRepository;
        $this->logger = $logger;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Actual;
    }

    /**
     *
     * @param  Actual $data
     */
    public function persist($data, array $context = [])
    {
        if ($context["collection_operation_name"] ?? null === 'POST'){
            $obra = $data->getObra();
            $numCasas = $obra->getCasas();
            $partida = $data->getPartida();

            $presupuesto = $this->presupuestoRepository->findOneBy([
                'obra' => $obra,
                'partida' => $partida
            ]);

            if(!$presupuesto){
                throw new PresupuestoNotFoundException(sprintf("La partida %s no esta en el presupuesto de la obra %s", $partida->getNombre(), $obra->getNombre()));
            }

            $totalPresupuesto = $presupuesto->getPresactu();
            $data->setTotal($data->getCasas() / $numCasas * $totalPresupuesto);
            $this->em->persist($data);
            $this->em->flush();

            $partida = $partida->getPadre();

            while ($partida){
                $actual = $this->actualRepository->findOneBy([
                    'obra' => $obra,
                    'partida' => $partida
                ]);

                if(!$actual){
                    $actual = new Actual;
                    $actual->setObra($obra);
                    $actual->setPartida($partida);
                    $actual->setTotal(0);
                }

                $actual->setTotal($actual->getTotal() + $data->getTotal());
                $this->em->persist($actual);
                $this->em->flush();

                $partida = $partida->getPadre();
            }
        }


        if ($context["item_operation_name"] ?? null === 'PUT'){
            $this->logger->debug(("updating"));
            $prevActual = $this->em->getUnitOfWork()->getOriginalEntityData($data);

            $obra = $data->getObra();
            $numCasas = $obra->getCasas();
            $partida = $data->getPartida();

            $presupuesto = $this->presupuestoRepository->findOneBy([
                'obra' => $obra,
                'partida' => $partida
            ]);

            if(!$presupuesto){
                throw new PresupuestoNotFoundException(sprintf("La partida %s no esta en el presupuesto de la obra %s", $partida->getNombre(), $obra->getNombre()));
            }

            $totalPresupuesto = $presupuesto->getPresactu();
            $data->setTotal($data->getCasas() / $numCasas * $totalPresupuesto);
            $this->em->persist($data);
            $this->em->flush();

            $prevTotal = $prevActual['total'];
            $diff = $data->getTotal() - $prevTotal;
            $partida = $partida->getPadre();

            while($partida){
                $actual = $this->actualRepository->findOneBy([
                    'obra' => $obra,
                    'partida' => $partida
                ]);

                $actual->setTotal($actual->getTotal() + $diff);
                $this->em->persist($actual);
                $this->em->flush();

                $partida = $partida->getPadre();
            }
        }
    }

    public function remove($data, array $context = [])
    {
        // TODO implement this method
        throw new \Exception("Not allowed to delete");
    }
}
