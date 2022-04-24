<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DetalleFacturaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetalleFacturaRepository::class)]
#[ApiResource]
class DetalleFactura
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    private $cantidad;

    #[ORM\Column(type: 'float')]
    private $unitario;

    #[ORM\Column(type: 'float')]
    private $total;

    #[ORM\ManyToOne(targetEntity: Factura::class, inversedBy: 'detalleFacturas')]
    #[ORM\JoinColumn(nullable: false)]
    private $factura;

    #[ORM\ManyToOne(targetEntity: Partida::class, inversedBy: 'detalleFacturas')]
    #[ORM\JoinColumn(nullable: false)]
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
