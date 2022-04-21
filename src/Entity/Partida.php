<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partida
 *
 * @ORM\Table(name="partida", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_A9C1580C20332D99", columns={"codigo"}), @ORM\UniqueConstraint(name="UNIQ_A9C1580C3A909126", columns={"nombre"})}, indexes={@ORM\Index(name="IDX_A9C1580C613CEC58", columns={"padre_id"})})
 * @ORM\Entity
 */
class Partida
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
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=50, nullable=false)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var bool
     *
     * @ORM\Column(name="acumula", type="boolean", nullable=false)
     */
    private $acumula;

    /**
     * @var int
     *
     * @ORM\Column(name="nivel", type="integer", nullable=false)
     */
    private $nivel;

    /**
     * @var \Partida
     *
     * @ORM\ManyToOne(targetEntity="Partida")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="padre_id", referencedColumnName="id")
     * })
     */
    private $padre;


}
