<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RepasMenus
 *
 * @ORM\Table(name="repas_menus", indexes={@ORM\Index(name="fk_repas_menu", columns={"repas_id"}), @ORM\Index(name="fk_menu_repas", columns={"menu_id"})})
 * @ORM\Entity
 */
class RepasMenus
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
     * @ORM\Column(name="menu_id", type="integer", nullable=true)
     */
    private $menuId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="repas_id", type="integer", nullable=true)
     */
    private $repasId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="menus_quantite", type="integer", nullable=true)
     */
    private $menusQuantite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMenuId(): ?int
    {
        return $this->menuId;
    }

    public function setMenuId(?int $menuId): self
    {
        $this->menuId = $menuId;

        return $this;
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

    public function getMenusQuantite(): ?int
    {
        return $this->menusQuantite;
    }

    public function setMenusQuantite(?int $menusQuantite): self
    {
        $this->menusQuantite = $menusQuantite;

        return $this;
    }


}
