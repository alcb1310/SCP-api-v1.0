<?php

namespace App\DataPersister;

use App\Entity\DetalleFactura;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Repository\PresupuestoRepository;
use Psr\Log\LoggerInterface;

class DetalleFacturaDataPersister implements ContextAwareDataPersisterInterface
{

    private $em;
    private $logger;
    /**
     * presupuestoRepository
     *
     * @var PresupuestoRepository
     */
    private $presupuestoRepository;

    public function __construct(EntityManagerInterface $em, LoggerInterface $logger, PresupuestoRepository $presupuestoRepository)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->presupuestoRepository = $presupuestoRepository;
    }

    public function supports($data, array $context = []): bool
    {
        // TODO implement this method
        return $data instanceof DetalleFactura;
    }

    /**
     * persist
     *
     * @param  DetalleFactura $data
     */
    public function persist($data, array $context = [])
    {
        // TODO implement this method
        $this->em->beginTransaction();
        try{
            if ($context["item_operation_name"] ?? null === 'PUT'){
                // TODO put operation
                $this->logger->debug("Actualizando detalle factura");
            }

            if ($context["collection_operation_name"] ?? null === 'POST'){
                // TODO post operation
                $this->logger->debug("Creando detalle factura");
                $data->setTotal($data->getCantidad() * $data->getUnitario());
                $this->em->persist($data);
                $this->em->flush();

                $factura = $data->getFactura();
                $factura->setTotal($factura->getTotal() + $data->getTotal());
                $this->em->persist($factura);
                $this->em->flush();

                $partida = $data->getPartida();
                $obra = $factura->getObra();
                $presupuesto = $this->presupuestoRepository->findOneBy([
                    'partida' => $partida,
                    'obra' => $obra
                ]);

                $oldpresupuesto= $presupuesto->getPorgastot();
                $presupuesto->setRendidocant($presupuesto->getRendidocant() + $data->getCantidad());
                $presupuesto->setReniddotot($presupuesto->getReniddotot() + $data->getTotal());
                $presupuesto->setPorgascan($presupuesto->getPorgascan() - $data->getCantidad());
                $presupuesto->setPorgascost($data->getUnitario());
                $presupuesto->setPorgastot($presupuesto->getPorgascan() * $presupuesto->getPorgascost());
                $presupuesto->setPresactu($presupuesto->getReniddotot() + $presupuesto->getPorgastot());
                $this->em->persist($presupuesto);
                $this->em->flush();

                $diff =  $presupuesto->getPorgastot() - $oldpresupuesto;

                $partida = $partida->getPadre();
                $this->logger->debug($partida->getCodigo());

                while ($partida){
                    $presupuesto = $this->presupuestoRepository->findOneBy([
                        'partida' => $partida,
                        'obra' => $obra,
                    ]);

                    $presupuesto->setReniddotot($presupuesto->getReniddotot() + $data->getTotal());
                    $presupuesto->setPorgastot($presupuesto->getPorgastot() + $diff);
                    $presupuesto->setPresactu($presupuesto->getReniddotot() + $presupuesto->getPorgastot());
                    $this->em->persist($presupuesto);
                    $this->em->flush();

                    $partida = $partida->getPadre();
                }

            }
            $this->em->commit();
        } catch (\Exception $e){
            $this->em->rollback();
            return json_encode($e);
        }
    }

    /**
     * remove
     *
     * @param  DetalleFactura $data
     */
    public function remove($data, array $context = [])
    {
        // TODO implement this method
        $this->em->beginTransaction();
        try{
            $this->logger->debug("Borrando detalle factura");
            $this->logger->debug($data->getPartida()->getCodigo());
            $factura = $data->getFactura();
            $obra = $factura->getObra();
            $this->logger->debug(sprintf("obra: %s", $obra->getNombre()));

            $factura->setTotal($factura->getTotal() - $data->getTotal());
            $this->em->persist($factura);
            $this->em->flush();

            $partida = $data->getPartida();
            $presupuesto = $this->presupuestoRepository->findOneBy([
                'partida' => $partida,
                'obra' => $obra
            ]);

            $presupuesto->setRendidocant($presupuesto->getRendidocant() - $data->getCantidad());
            $presupuesto->setReniddotot($presupuesto->getReniddotot() - $data->getTotal());
            $presupuesto->setPorgascan($presupuesto->getPorgascan() + $data->getCantidad());
            $presupuesto->setPorgastot($presupuesto->getPorgastot() + $data->getTotal());
            $this->em->persist($presupuesto);
            $this->em->flush();

            $partida = $partida->getPadre();

            while($partida){
                $presupuesto = $this->presupuestoRepository->findOneBy([
                    'partida' => $partida,
                    'obra' => $obra
                ]);

                $presupuesto->setReniddotot($presupuesto->getReniddotot() - $data->getTotal());
                $presupuesto->setPorgastot($presupuesto->getPorgastot() + $data->getTotal());
                $this->persist($presupuesto);
                $this->em->flush();

                $partida = $partida->getPadre();
            }

            $this->em->remove($data);
            $this->em->flush();

            $this->em->commit();
        } catch (\Exception $e){
            $this->em->rollback();
            return json_encode($e);
        }
    }
}
