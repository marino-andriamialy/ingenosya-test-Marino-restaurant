<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RepasMenusController extends AbstractController
{
    /**
     * @Route("/repas/menus", name="repas_menus")
     */
    public function index(): Response
    {
        return $this->render('repas_menus/index.html.twig', [
            'controller_name' => 'RepasMenusController',
        ]);
    }
}
