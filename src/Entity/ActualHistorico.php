<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ActualHistoricoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ActualHistoricoRepository::class)]
#[ApiResource(
    collectionOperations: ['GET'],
    itemOperations: ['GET'],
    normalizationContext:['groups' => 'actual-historico:read']
)]
class ActualHistorico
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    #[Groups(['actual-historico:read'])]
    private $fecha;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(['actual-historico:read'])]
    private $casas;

    #[ORM\Column(type: 'float')]
    #[Groups(['actual-historico:read'])]
    private $total;

    #[ORM\ManyToOne(targetEntity: Obra::class, inversedBy: 'actualHistoricos')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['actual-historico:read'])]
    private $obra;

    #[ORM\ManyToOne(targetEntity: Partida::class, inversedBy: 'actualHistoricos')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['actual-historico:read'])]
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

    public function getCasas(): ?float
    {
        return $this->casas;
    }

    public function setCasas(?float $casas): self
    {
        $this->casas = $casas;

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
