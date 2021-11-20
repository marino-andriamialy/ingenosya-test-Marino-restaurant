<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenusIngredientsController extends AbstractController
{
    /**
     * @Route("/menus/ingredients", name="menus_ingredients")
     */
    public function index(): Response
    {
        return $this->render('menus_ingredients/index.html.twig', [
            'controller_name' => 'MenusIngredientsController',
        ]);
    }
}
