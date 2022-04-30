<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProveedorRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProveedorRepository::class)]
#[ApiResource(
    security: 'is_granted("ROLE_USER")',
    collectionOperations:[
        'get',
        'post'
    ],
    itemOperations: [
        'get',
        'put'
    ],
    normalizationContext: [
        'groups' => ['proveedor:read']
    ],
    denormalizationContext:[
        'groups' => ['proveedor:write']
    ]
)]
#[UniqueEntity(
    fields: ['ruc'],
    errorPath: 'ruc',
    message: 'Ya existe un proveedor con ese RUC'
)]
#[UniqueEntity(
    fields: ['nombre'],
    errorPath: 'nombre',
    message: 'Ya existe un proveedor con ese nombre'
)]
#[ApiFilter(SearchFilter::class, properties:['nombre' => 'partial', 'ruc' => 'exact'])]
class Proveedor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 20)]
    #[Groups([
        'proveedor:read',
        'proveedor:write'
    ])]
    #[Assert\NotBlank(
        message:'Ingrese un RUC para el proveedor'
    )]
    #[Assert\Length(
        min: 10,
        minMessage: 'El RUC debe tener al menos 10 caracteres'
    )]
    private $ruc;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        'proveedor:read',
        'proveedor:write',
        'factura:read'
    ])]
    #[Assert\NotBlank(
        message: 'Ingrese un nombre para el proveedor'
    )]
    #[Assert\Length(
        min: 2,
        minMessage: 'El nombre del proveedor debe tener al menos dos caracteres'
    )]
    private $nombre;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([
        'proveedor:read',
        'proveedor:write'
    ])]
    private $contacto;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([
        'proveedor:read',
        'proveedor:write'
    ])]
    private $telefono;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([
        'proveedor:read',
        'proveedor:write'
    ])]
    #[Assert\Email(
        message: 'Ingrese un correo electronico valido'
    )]
    private $email;

    #[ORM\OneToMany(mappedBy: 'proveedor', targetEntity: Factura::class)]
    #[Groups([
        'proveedor:read',
    ])]
    private $facturas;

    public function __construct()
    {
        $this->facturas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRuc(): ?string
    {
        return $this->ruc;
    }

    public function setRuc(string $ruc): self
    {
        $this->ruc = $ruc;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getContacto(): ?string
    {
        return $this->contacto;
    }

    public function setContacto(?string $contacto): self
    {
        $this->contacto = $contacto;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Factura>
     */
    public function getFacturas(): Collection
    {
        return $this->facturas;
    }

    public function addFactura(Factura $factura): self
    {
        if (!$this->facturas->contains($factura)) {
            $this->facturas[] = $factura;
            $factura->setProveedor($this);
        }

        return $this;
    }

    public function removeFactura(Factura $factura): self
    {
        if ($this->facturas->removeElement($factura)) {
            // set the owning side to null (unless already changed)
            if ($factura->getProveedor() === $this) {
                $factura->setProveedor(null);
            }
        }

        return $this;
    }
}
