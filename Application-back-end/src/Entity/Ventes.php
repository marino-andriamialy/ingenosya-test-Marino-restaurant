<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ventes
 *
 * @ORM\Table(name="ventes", indexes={@ORM\Index(name="fk_ventes_repas", columns={"repas_id"})})
 * @ORM\Entity
 */
class Ventes
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
     * @var int|null
     *
     * @ORM\Column(name="repas_id", type="integer", nullable=true)
     */
    private $repasId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="quantite", type="integer", nullable=true)
     */
    private $quantite;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="emballages", type="boolean", nullable=true)
     */
    private $emballages;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="serviettes", type="boolean", nullable=true)
     */
    private $serviettes;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="couvert", type="boolean", nullable=true)
     */
    private $couvert;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepasId(): ?int
    {
        return $this->repasId;
    }

    public function setRepasId(?int $repasId): self
    {
        $this->repasId = $repasId;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getEmballages(): ?bool
    {
        return $this->emballages;
    }

    public function setEmballages(?bool $emballages): self
    {
        $this->emballages = $emballages;

        return $this;
    }

    public function getServiettes(): ?bool
    {
        return $this->serviettes;
    }

    public function setServiettes(?bool $serviettes): self
    {
        $this->serviettes = $serviettes;

        return $this;
    }

    public function getCouvert(): ?bool
    {
        return $this->couvert;
    }

    public function setCouvert(?bool $couvert): self
    {
        $this->couvert = $couvert;

        return $this;
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
