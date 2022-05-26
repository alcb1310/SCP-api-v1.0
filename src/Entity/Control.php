<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ControlRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ControlRepository::class)]
#[ApiResource(
    security: 'is_granted("ROLE_USER")',
    collectionOperations:[
        'get'
    ],
    itemOperations: [
        'get'
    ],
    normalizationContext:['groups'=>'control:read']
)]
class Control
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    #[Groups('control:read')]
    private $fecha;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups('control:read')]
    private $cantini;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups('control:read')]
    private $costoini;

    #[ORM\Column(type: 'float')]
    #[Groups('control:read')]
    private $totalini;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups('control:read')]
    private $rendidocant;

    #[ORM\Column(type: 'float')]
    #[Groups('control:read')]
    private $rendidotot;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups('control:read')]
    private $porgascan;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups('control:read')]
    private $porgascost;

    #[ORM\Column(type: 'float')]
    #[Groups('control:read')]
    private $porgastot;

    #[ORM\Column(type: 'float')]
    #[Groups('control:read')]
    private $presactu;

    #[ORM\ManyToOne(targetEntity: Obra::class, inversedBy: 'controls')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('control:read')]
    private $obra;

    #[ORM\ManyToOne(targetEntity: Partida::class, inversedBy: 'controls')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('control:read')]
    private $partida;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCantini(): ?float
    {
        return $this->cantini;
    }

    public function setCantini(?float $cantini): self
    {
        $this->cantini = $cantini;

        return $this;
    }

    public function getCostoini(): ?float
    {
        return $this->costoini;
    }

    public function setCostoini(?float $costoini): self
    {
        $this->costoini = $costoini;

        return $this;
    }

    public function getTotalini(): ?float
    {
        return $this->totalini;
    }

    public function setTotalini(float $totalini): self
    {
        $this->totalini = $totalini;

        return $this;
    }

    public function getRendidocant(): ?float
    {
        return $this->rendidocant;
    }

    public function setRendidocant(?float $rendidocant): self
    {
        $this->rendidocant = $rendidocant;

        return $this;
    }

    public function getRendidotot(): ?float
    {
        return $this->rendidotot;
    }

    public function setRendidotot(float $rendidotot): self
    {
        $this->rendidotot = $rendidotot;

        return $this;
    }

    public function getPorgascan(): ?float
    {
        return $this->porgascan;
    }

    public function setPorgascan(?float $porgascan): self
    {
        $this->porgascan = $porgascan;

        return $this;
    }

    public function getPorgascost(): ?float
    {
        return $this->porgascost;
    }

    public function setPorgascost(?float $porgascost): self
    {
        $this->porgascost = $porgascost;

        return $this;
    }

    public function getPorgastot(): ?float
    {
        return $this->porgastot;
    }

    public function setPorgastot(float $porgastot): self
    {
        $this->porgastot = $porgastot;

        return $this;
    }

    public function getPresactu(): ?float
    {
        return $this->presactu;
    }

    public function setPresactu(float $presactu): self
    {
        $this->presactu = $presactu;

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
