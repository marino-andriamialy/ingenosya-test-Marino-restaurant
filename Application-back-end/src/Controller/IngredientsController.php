<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Ingredients;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;

class IngredientsController extends AbstractController
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/ingredients", name="ingredients")
     */
    public function index(): Response
    {
        return $this->render('ingredients/index.html.twig', [
            'controller_name' => 'IngredientsController',
        ]);
    }

    /**
     * @Route("/ingredients/{id}", name="ingredient")
     */
    public function ingredient(int $id): Response
    {
        $qb = $this->entityManager->createQueryBuilder();
        $response = new JsonResponse();
        // $Ingredients = $this->getDoctrine()->getRepository(Ingredients::class)->findAll();
        try{
            $qb->add('select', 'u')
                ->add('from', 'App:Ingredients u')
                ->add('where', 'u.id = ?1')
                ->setParameter(1, $id);
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
     * @Route("/tout-ingredient", name="all_ingredient")
     */
    public function toutIngredient()
    {
        $qb = $this->entityManager->createQueryBuilder();
        $response = new JsonResponse();
        // $Ingredients = $this->getDoctrine()->getRepository(Ingredients::class)->findAll();
        try{
            $qb->add('select', 'u')
                ->add('from', 'App:Ingredients u')
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
     * @Route("/add-ingredient", name="add_ingredient", methods={"POST"})
     */
    public function addIngredient(Request $request): Response
    {
        $response = new JsonResponse();
        $entityManager = $this->getDoctrine()->getManager();
        $ingredients = new Ingredients();
        try{
            $dataPost = json_decode($request->getContent(), true); 
            $ingredients->setNom($dataPost["nom"]);
            $ingredients->setUnite($dataPost["unite"]);
            $ingredients->setStock($dataPost["stock"]);
            $entityManager->persist($ingredients);
            $entityManager->flush();
            $result = array("status"=> "OK", "data"=>$dataPost);
        } catch (\Exception $exception) {
            $result = array("status"=> "ERROR", "message"=>$exception->getMessage());
        }
        $response->setData($result);
        return $response;
    }

    /**
     * @Route("/modify-ingredient", name="modify_ingredient", methods={"POST","PUT"})
     */
    public function modifyIngredient(Request $request): Response
    {
        $response = new JsonResponse();
        $entityManager = $this->getDoctrine()->getManager();
        
        try{
            $dataPost = json_decode($request->getContent(), true); 
            $ingredients = $this->getDoctrine()->getRepository(Ingredients::class)->find($dataPost["id"]);
           
            $ingredients->setNom($dataPost["nom"]);
            $ingredients->setUnite($dataPost["unite"]);
            $ingredients->setStock($dataPost["stock"]);
            $entityManager->persist($ingredients);
            $entityManager->flush();
            $result = array("status"=> "OK", "data"=>$dataPost);
        } catch (\Exception $exception) {
            $result = array("status"=> "ERROR", "message"=>$exception->getMessage());
        }
        $response->setData($result);
        return $response;
    }

    /**
     * @Route("/delete-ingredient/{id}", name="delete_ingredient")
     */
    public function deleteIngredient(int $id): Response
    {
        $response = new JsonResponse();
        try{
            $entityManager = $this->getDoctrine()->getManager();
            $ingredients = $this->getDoctrine()->getRepository(Ingredients::class)->find($id);
            $entityManager->remove($ingredients);
            $entityManager->flush();
            $result = array("status"=> "OK", "data"=>$ingredients->getNom()." Supprimer avec success" );
        } catch (\Exception $exception) {
            $result = array("status"=> "ERROR", "message"=>$exception->getMessage());
        }
        $response->setData($result);
        return $response;
    }
}
