<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FacturaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FacturaRepository::class)]
#[ApiResource(
    security: 'is_granted("ROLE_USER")',
    collectionOperations:[
        'GET',
        'POST' => [
            'denormalization_context' => ['groups' => 'factura:write']
        ],
    ],
    itemOperations:[
        'GET',
        'PUT' => [
            'denormalization_context' => ['groups'=>'factura:item:write']
        ]
    ],
    normalizationContext:[
        'groups' => ['factura:read']
    ],
)]
#[UniqueEntity(
    fields: ['proveedor', 'numero', 'obra'],
    errorPath: 'numero',
    message: 'El numero de factura para ese proveedor en esa obra ya existe'
)]
class Factura
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups([
        'factura:read',
        'factura:write',
        'factura:item:write'
    ])]
    private $numero;

    #[ORM\Column(type: 'date')]
    #[Groups([
        'factura:read',
        'factura:write',
        'factura:item:write'
    ])]
    private $fecha;

    #[ORM\Column(type: 'float')]
    #[Groups([
        'factura:read'
    ])]
    private $total =0;

    #[ORM\ManyToOne(targetEntity: Obra::class, inversedBy: 'facturas')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'factura:read',
        'factura:write'
    ])]
    private $obra;

    #[ORM\ManyToOne(targetEntity: Proveedor::class, inversedBy: 'facturas')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'factura:read',
        'factura:write'
    ])]
    private $proveedor;

    #[ORM\OneToMany(mappedBy: 'factura', targetEntity: DetalleFactura::class)]
    #[Groups([
        'factura:read'
    ])]
    private $detalleFacturas;

    public function __construct()
    {
        $this->detalleFacturas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

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

    public function getObra(): ?Obra
    {
        return $this->obra;
    }

    public function setObra(?Obra $obra): self
    {
        $this->obra = $obra;

        return $this;
    }

    public function getProveedor(): ?Proveedor
    {
        return $this->proveedor;
    }

    public function setProveedor(?Proveedor $proveedor): self
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * @return Collection<int, DetalleFactura>
     */
    public function getDetalleFacturas(): Collection
    {
        return $this->detalleFacturas;
    }

    public function addDetalleFactura(DetalleFactura $detalleFactura): self
    {
        if (!$this->detalleFacturas->contains($detalleFactura)) {
            $this->detalleFacturas[] = $detalleFactura;
            $detalleFactura->setFactura($this);
        }

        return $this;
    }

    public function removeDetalleFactura(DetalleFactura $detalleFactura): self
    {
        if ($this->detalleFacturas->removeElement($detalleFactura)) {
            // set the owning side to null (unless already changed)
            if ($detalleFactura->getFactura() === $this) {
                $detalleFactura->setFactura(null);
            }
        }

        return $this;
    }
}
