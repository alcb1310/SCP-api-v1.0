<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actual
 *
 * @ORM\Table(name="actual", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_227D9A243C2672C8F15A1987", columns={"obra_id", "partida_id"})}, indexes={@ORM\Index(name="IDX_227D9A243C2672C8", columns={"obra_id"}), @ORM\Index(name="IDX_227D9A24F15A1987", columns={"partida_id"})})
 * @ORM\Entity
 */
class Actual
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
     * @ORM\Column(name="casas", type="float", precision=10, scale=0, nullable=true)
     */
    private $casas;

    /**
     * @var float|null
     *
     * @ORM\Column(name="total", type="float", precision=10, scale=0, nullable=true)
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
