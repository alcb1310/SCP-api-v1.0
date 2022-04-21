<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Control
 *
 * @ORM\Table(name="control", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_EDDB2C4B3C2672C8F15A19871A8B7D9", columns={"obra_id", "partida_id", "fecha"})}, indexes={@ORM\Index(name="IDX_EDDB2C4B3C2672C8", columns={"obra_id"}), @ORM\Index(name="IDX_EDDB2C4BF15A1987", columns={"partida_id"})})
 * @ORM\Entity
 */
class Control
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=false)
     */
    private $fecha;

    /**
     * @var float|null
     *
     * @ORM\Column(name="cantini", type="float", precision=10, scale=0, nullable=true)
     */
    private $cantini;

    /**
     * @var float|null
     *
     * @ORM\Column(name="costoini", type="float", precision=10, scale=0, nullable=true)
     */
    private $costoini;

    /**
     * @var float|null
     *
     * @ORM\Column(name="totalini", type="float", precision=10, scale=0, nullable=true)
     */
    private $totalini;

    /**
     * @var float|null
     *
     * @ORM\Column(name="rendidocant", type="float", precision=10, scale=0, nullable=true)
     */
    private $rendidocant;

    /**
     * @var float|null
     *
     * @ORM\Column(name="rendidotot", type="float", precision=10, scale=0, nullable=true)
     */
    private $rendidotot;

    /**
     * @var float|null
     *
     * @ORM\Column(name="porgascan", type="float", precision=10, scale=0, nullable=true)
     */
    private $porgascan;

    /**
     * @var float|null
     *
     * @ORM\Column(name="porgascost", type="float", precision=10, scale=0, nullable=true)
     */
    private $porgascost;

    /**
     * @var float|null
     *
     * @ORM\Column(name="porgastot", type="float", precision=10, scale=0, nullable=true)
     */
    private $porgastot;

    /**
     * @var float|null
     *
     * @ORM\Column(name="presactu", type="float", precision=10, scale=0, nullable=true)
     */
    private $presactu;

    /**
     * @var \Obra
     *
     * @ORM\ManyToOne(targetEntity="Obra")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="obra_id", referencedColumnName="id")
     * })
     */
    private $obra;

    /**
     * @var \Partida
     *
     * @ORM\ManyToOne(targetEntity="Partida")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="partida_id", referencedColumnName="id")
     * })
     */
    private $partida;


}
