<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActualHistorico
 *
 * @ORM\Table(name="actual_historico", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_B64C53893C2672C8F15A19871A8B7D9", columns={"obra_id", "partida_id", "fecha"})}, indexes={@ORM\Index(name="IDX_B64C53893C2672C8", columns={"obra_id"}), @ORM\Index(name="IDX_B64C5389F15A1987", columns={"partida_id"})})
 * @ORM\Entity
 */
class ActualHistorico
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
     * @ORM\Column(name="casas", type="float", precision=10, scale=0, nullable=true)
     */
    private $casas;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=10, scale=0, nullable=false)
     */
    private $total;

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
