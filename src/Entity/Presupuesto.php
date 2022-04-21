<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Presupuesto
 *
 * @ORM\Table(name="presupuesto", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_1B6368D33C2672C8F15A1987", columns={"obra_id", "partida_id"})}, indexes={@ORM\Index(name="IDX_1B6368D33C2672C8", columns={"obra_id"}), @ORM\Index(name="IDX_1B6368D3F15A1987", columns={"partida_id"})})
 * @ORM\Entity
 */
class Presupuesto
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
     * @var float
     *
     * @ORM\Column(name="totalini", type="float", precision=10, scale=0, nullable=false)
     */
    private $totalini;

    /**
     * @var float|null
     *
     * @ORM\Column(name="rendidocant", type="float", precision=10, scale=0, nullable=true)
     */
    private $rendidocant;

    /**
     * @var float
     *
     * @ORM\Column(name="rendidotot", type="float", precision=10, scale=0, nullable=false)
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
     * @var float
     *
     * @ORM\Column(name="porgastot", type="float", precision=10, scale=0, nullable=false)
     */
    private $porgastot;

    /**
     * @var float
     *
     * @ORM\Column(name="presactu", type="float", precision=10, scale=0, nullable=false)
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
