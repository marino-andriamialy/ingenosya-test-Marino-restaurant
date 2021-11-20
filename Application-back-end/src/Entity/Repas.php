<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Repas
 *
 * @ORM\Table(name="repas")
 * @ORM\Entity
 */
class Repas
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
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creer_le", type="datetime", nullable=false)
     */
    private $creerLe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prix", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $prix;

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreerLe(): ?\DateTimeInterface
    {
        return $this->creerLe;
    }

    public function setCreerLe(\DateTimeInterface $creerLe): self
    {
        $this->creerLe = $creerLe;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(?string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }


}
