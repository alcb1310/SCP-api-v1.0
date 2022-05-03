<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ActualRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ActualRepository::class)]
#[ApiResource(
    security: 'is_granted("ROLE_USER")',
    collectionOperations: [
        'GET',
        'POST' => [
            'denormalization_context' => ['groups' => 'actual:write']
        ]
    ],
    itemOperations: [
        'GET',
        'PUT' => [
            'denormalization_context' => ['groups' => 'actual:item:write']
        ]
    ],
    normalizationContext:['groups' => 'actual:read'],
)]
class Actual
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups([
        'actual:read',
        'actual:write',
        'actual:item:write'
    ])]
    private $casas;

    #[ORM\Column(type: 'float')]
    #[Groups([
        'actual:read',
    ])]
    private $total;

    #[ORM\ManyToOne(targetEntity: Obra::class, inversedBy: 'actuals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'actual:read',
        'actual:write'
    ])]
    private $obra;

    #[ORM\ManyToOne(targetEntity: Partida::class, inversedBy: 'actuals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'actual:read',
        'actual:write'
    ])]
    private $partida;

    public function getId(): ?int
    {
        return $this->id;
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
