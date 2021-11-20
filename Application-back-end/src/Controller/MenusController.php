<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Menus;
use App\Entity\MenusIngredients;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManagerInterface;

class MenusController extends AbstractController
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/menus", name="menus")
     */
    public function index(): Response
    {
        return $this->render('menus/index.html.twig', [
            'controller_name' => 'MenusController',
        ]);
    }

    /**
     * @Route("/menus/{id}", name="menu")
     */
    public function menu(int $id): Response
    {
        $qb = $this->entityManager->createQueryBuilder();
        $response = new JsonResponse();
        // $Menus = $this->getDoctrine()->getRepository(Menus::class)->findAll();
        try{
            $qb->add('select', 'u')
                ->add('from', 'App:Menus u')
                ->add('where', 'u.id = ?1')
                ->setParameter(1, $id);
            $query = $qb->getQuery();
            $result = $query->getArrayResult();
            $result = array("status"=> "OK", "data"=>$result);
            $response->setData($result);
        } catch (\Exception $exception) {
            $result = array("status"=> "ERROR", "message"=>$exception->getMessage());
            $response->setData($result);
        }

        return $response;
    }
    

    /**
     * @Route("/tout-menu-ingredient/{id}", name="all_menu_ingredient")
     */
    public function toutIngredientMenu(int $id)
    {
        $response = new JsonResponse();
        // $Menus = $this->getDoctrine()->getRepository(Menus::class)->findAll();
        try{
            $query = $this->entityManager
            ->createQuery("SELECT u.id, u.ingredientQuantite 
            as quantite, a.nom, a.unite, a.stock, u.ingredientId
            FROM App:MenusIngredients u 
            JOIN App:Ingredients a 
            WHERE a.id = u.ingredientId
            AND u.menusId = :identifier");
            $query->setParameter('identifier', $id);
            $result = $query->getArrayResult();
        
            //$result = array("status"=> "OK", "data"=>$result);
            $response->setData($result);
        } catch (\Exception $exception) {
            $result = array("status"=> "ERROR", "message"=>$exception->getMessage());
            $response->setData($result);
        }

        return $response;
    }
    /**
     * @Route("/tout-menu", name="all_menu")
     */
    public function toutMenu()
    {
        $qb = $this->entityManager->createQueryBuilder();
        $response = new JsonResponse();
        // $Menus = $this->getDoctrine()->getRepository(Menus::class)->findAll();
        try{
            $qb->add('select', 'u')
                ->add('from', 'App:Menus u')
                ->add('where', 'u.id IS NOT NULL');
            $query = $qb->getQuery();
            $result = $query->getArrayResult();
        
            //$result = array("status"=> "OK", "data"=>$result);
            $response->setData($result);
        } catch (\Exception $exception) {
            $result = array("status"=> "ERROR", "message"=>$exception->getMessage());
            $response->setData($result);
        }

        return $response;
    }

     /**
     * @Route("/add-menu", name="add_menu", methods={"POST"})
     */
    public function addMenu(Request $request): Response
    {
        $response = new JsonResponse();
        $entityManager = $this->getDoctrine()->getManager();
        $menus = new Menus();
        try{
            $dataPost = json_decode($request->getContent(), true); 
            //var_dump($dataPost); die;
            $menus->setNom($dataPost["menu"]["nom"]);
            $menus->setPrixUnitaire($dataPost["menu"]["prixUnitaire"]);
            $entityManager->persist($menus);
            $entityManager->flush();

            foreach($dataPost["ingredient"] as $ingredient){
                $menusIngredients = new MenusIngredients();
                $menusIngredients->setMenusId($menus->getId());
                $menusIngredients->setIngredientId($ingredient["ingredientId"]);
                $menusIngredients->setIngredientQuantite($ingredient["quantite"]);
                $entityManager->persist($menusIngredients);
                $entityManager->flush();
            }
            //$result = array("status"=> "OK", "data"=>$dataPost);
            $result = $dataPost;
        } catch (\Exception $exception) {
            $result = array("status"=> "ERROR", "message"=>$exception->getMessage());
        }
        $response->setData($result);
        return $response;
    }

    /**
     * @Route("/modify-menu", name="modify_menu", methods={"POST","PUT"})
     */
    public function modifyMenu(Request $request): Response
    {
        $response = new JsonResponse();
        $entityManager = $this->getDoctrine()->getManager();
        
        try{
            $dataPost = json_decode($request->getContent(), true); 
            $menus = $this->getDoctrine()->getRepository(Menus::class)->find($dataPost["menu"]["id"]);
           
            $menus->setNom($dataPost["menu"]["nom"]);
            $menus->setPrixUnitaire($dataPost["menu"]["prixUnitaire"]);
            $entityManager->persist($menus);
            $entityManager->flush();
            foreach($dataPost["ingredient"] as $ingredientMenu){
                if(isset($ingredientMenu['id'])){

                    $menusIngredients = $this->getDoctrine()->getRepository(MenusIngredients::class)->find($ingredientMenu["id"]);
                    $menusIngredients->setMenusId($menus->getId());
                    $menusIngredients->setIngredientId($ingredientMenu["ingredientId"]);
                    $menusIngredients->setIngredientQuantite($ingredientMenu["quantite"]);
                    $entityManager->persist($menusIngredients);
                    $entityManager->flush();
                    
                }else{
                    $menusIngredients = new MenusIngredients();
                    $menusIngredients->setMenusId($menus->getId());
                    $menusIngredients->setIngredientId($ingredientMenu["ingredientId"]);
                    $menusIngredients->setIngredientQuantite($ingredientMenu["quantite"]);
                    $entityManager->persist($menusIngredients);
                    $entityManager->flush();
                }
            }

            $result = $dataPost;
        } catch (\Exception $exception) {
            $result = array("status"=> "ERROR", "message"=>$exception->getMessage());
        }
        $response->setData($result);
        return $response;
    }

    /**
     * @Route("/delete-menu/{id}", name="delete_menu")
     */
    public function deleteMenu(int $id): Response
    {
        $response = new JsonResponse();
        try{
            $entityManager = $this->getDoctrine()->getManager();
            $menus = $this->getDoctrine()->getRepository(Menus::class)->find($id);
            $entityManager->remove($menus);
            $entityManager->flush();
            $result = array("status"=> "OK", "data"=>$menus->getNom()." Supprimer avec success" );
        } catch (\Exception $exception) {
            $result = array("status"=> "ERROR", "message"=>$exception->getMessage());
        }
        $response->setData($result);
        return $response;
    }
}
