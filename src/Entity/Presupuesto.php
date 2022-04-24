<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PresupuestoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PresupuestoRepository::class)]
#[ApiResource()]
class Presupuesto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float', nullable: true)]
    private $cantini;

    #[ORM\Column(type: 'float', nullable: true)]
    private $costoini;

    #[ORM\Column(type: 'float')]
    private $totalini;

    #[ORM\Column(type: 'float', nullable: true)]
    private $rendidocant;

    #[ORM\Column(type: 'float')]
    private $reniddotot;

    #[ORM\Column(type: 'float', nullable: true)]
    private $porgascan;

    #[ORM\Column(type: 'float', nullable: true)]
    private $porgascost;

    #[ORM\Column(type: 'float')]
    private $porgastot;

    #[ORM\Column(type: 'float')]
    private $presactu;

    #[ORM\ManyToOne(targetEntity: Obra::class, inversedBy: 'presupuestos')]
    #[ORM\JoinColumn(nullable: false)]
    private $obra;

    #[ORM\ManyToOne(targetEntity: Partida::class, inversedBy: 'presupuestos')]
    #[ORM\JoinColumn(nullable: false)]
    private $partida;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getReniddotot(): ?float
    {
        return $this->reniddotot;
    }

    public function setReniddotot(float $reniddotot): self
    {
        $this->reniddotot = $reniddotot;

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
