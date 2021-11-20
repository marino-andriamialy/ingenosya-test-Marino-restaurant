<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenusIngredients
 *
 * @ORM\Table(name="menus_ingredients", indexes={@ORM\Index(name="fk_ingredient_menu", columns={"ingredient_id"}), @ORM\Index(name="fk_menu_ingredient", columns={"menus_id"})})
 * @ORM\Entity
 */
class MenusIngredients
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
     * @ORM\Column(name="menus_id", type="integer", nullable=true)
     */
    private $menusId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ingredient_id", type="integer", nullable=true)
     */
    private $ingredientId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ingredient_quantite", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $ingredientQuantite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMenusId(): ?int
    {
        return $this->menusId;
    }

    public function setMenusId(?int $menusId): self
    {
        $this->menusId = $menusId;

        return $this;
    }

    public function getIngredientId(): ?int
    {
        return $this->ingredientId;
    }

    public function setIngredientId(?int $ingredientId): self
    {
        $this->ingredientId = $ingredientId;

        return $this;
    }

    public function getIngredientQuantite(): ?string
    {
        return $this->ingredientQuantite;
    }

    public function setIngredientQuantite(?string $ingredientQuantite): self
    {
        $this->ingredientQuantite = $ingredientQuantite;

        return $this;
    }


}
