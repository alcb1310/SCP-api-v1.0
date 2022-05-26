<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DetalleFacturaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DetalleFacturaRepository::class)]
#[ApiResource(
    // security:'is_granted("ROLE_USER")',
    collectionOperations: [
        'get',
        'post'
    ],
    itemOperations: [
        'get',
        'delete'
    ],
    normalizationContext:[
        'groups' => ['detalle-factura:read']
    ],
    denormalizationContext:[
        'groups' => ['detalle-factura:write']
    ]
)]
class DetalleFactura
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Groups([
        'detalle-factura:read',
        'detalle-factura:write'
    ])]
    private $cantidad;

    #[ORM\Column(type: 'float')]
    #[Groups([
        'detalle-factura:read',
        'detalle-factura:write'
    ])]
    private $unitario;

    #[ORM\Column(type: 'float')]
    #[Groups([
        'detalle-factura:read'
    ])]
    private $total;

    #[ORM\ManyToOne(targetEntity: Factura::class, inversedBy: 'detalleFacturas')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'detalle-factura:read',
        'detalle-factura:write'
    ])]
    private $factura;

    #[ORM\ManyToOne(targetEntity: Partida::class, inversedBy: 'detalleFacturas')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'detalle-factura:read',
        'detalle-factura:write'
    ])]
    private $partida;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantidad(): ?float
    {
        return $this->cantidad;
    }

    public function setCantidad(float $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getUnitario(): ?float
    {
        return $this->unitario;
    }

    public function setUnitario(float $unitario): self
    {
        $this->unitario = $unitario;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getFactura(): ?Factura
    {
        return $this->factura;
    }

    public function setFactura(?Factura $factura): self
    {
        $this->factura = $factura;

        return $this;
    }

    public function getPartida(): ?Partida
    {
        return $this->partida;
    }

    public function setPartida(?Partida $partida): self
    {
        $this->partida = $partida;

        return $this;
    }
}
