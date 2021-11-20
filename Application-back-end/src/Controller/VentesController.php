<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Ventes;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManagerInterface;

class VentesController extends AbstractController
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/ventes", name="ventes")
     */
    public function index(): Response
    {
        return $this->render('ventes/index.html.twig', [
            'controller_name' => 'VentesController',
        ]);
    }

    /**
     * @Route("/ventes/{id}", name="vente")
     */
    public function vente(int $id): Response
    {
        $qb = $this->entityManager->createQueryBuilder();
        $response = new JsonResponse();
        // $Ventes = $this->getDoctrine()->getRepository(Ventes::class)->findAll();
        try{
            $qb->add('select', 'u')
                ->add('from', 'App:Ventes u')
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
     * @Route("/tout-vente", name="all_vente")
     */
    public function toutVente()
    {
        $qb = $this->entityManager->createQueryBuilder();
        $response = new JsonResponse();
        // $Ventes = $this->getDoctrine()->getRepository(Ventes::class)->findAll();
        try{
            // $qb->add('select', 'u')
            //     ->add('from', 'App:Ventes u')
            //     ->add('where', 'u.id IS NOT NULL');
            // $query = $qb->getQuery();
            // $result = $query->getArrayResult();
            $query = $this->entityManager
            ->createQuery("SELECT u.id,u.repasId,u.quantite,u.emballages,u.serviettes,u.couvert, a.nom,a.prix, u.prix as prixAchat
            FROM App:Ventes u 
            JOIN App:Repas a 
            WHERE a.id = u.repasId
            AND u.id IS NOT NULL");
            $result = $query->getArrayResult();
            $response->setData($result);
        } catch (\Exception $exception) {
            $result = array("status"=> "ERROR", "message"=>$exception->getMessage());
            $response->setData($result);
        }

        return $response;
    }

     /**
     * @Route("/add-vente", name="add_vente", methods={"POST"})
     */
    public function addVente(Request $request): Response
    {
        $response = new JsonResponse();
        $entityManager = $this->getDoctrine()->getManager();
        $ventes = new Ventes();
        try{
            $dataPost = json_decode($request->getContent(), true); 
            $ventes->setQuantite($dataPost["quantite"]);
            $today = date("yy-m-d H:i:s");
            $ventes->setCreerLe(new \DateTime($today));
            $ventes->setRepasId($dataPost["repasId"]);

            $ventes->setEmballages($dataPost["emballages"]);
            $ventes->setServiettes($dataPost["serviettes"]);
            $ventes->setCouvert($dataPost["couvert"]);


            $ventes->setPrix($dataPost["prix"]);
            $entityManager->persist($ventes);
            $entityManager->flush();
            $result = $dataPost;
            //$result = array("status"=> "OK", "data"=>$dataPost);
        } catch (\Exception $exception) {
            $result = array("status"=> "ERROR", "message"=>$exception->getMessage());
        }
        $response->setData($result);
        return $response;
    }

    /**
     * @Route("/modify-vente", name="modify_vente", methods={"POST","PUT"})
     */
    public function modifyVente(Request $request): Response
    {
        $response = new JsonResponse();
        $entityManager = $this->getDoctrine()->getManager();
        
        try{
            $dataPost = json_decode($request->getContent(), true); 
            $ventes = $this->getDoctrine()->getRepository(Ventes::class)->find($dataPost["id"]);
           
            $ventes->setQuantite($dataPost["quantite"]);
            $ventes->setRepasId($dataPost["repasId"]);
            $ventes->setPrix($dataPost["prix"]);
            $entityManager->persist($ventes);
            $entityManager->flush();
            //$result = array("status"=> "OK", "data"=>$dataPost);
            $result = $dataPost;
        } catch (\Exception $exception) {
            $result = array("status"=> "ERROR", "message"=>$exception->getMessage());
        }
        $response->setData($result);
        return $response;
    }

    /**
     * @Route("/delete-vente/{id}", name="delete_vente")
     */
    public function deleteVente(int $id): Response
    {
        $response = new JsonResponse();
        try{
            $entityManager = $this->getDoctrine()->getManager();
            $ventes = $this->getDoctrine()->getRepository(Ventes::class)->find($id);
            $entityManager->remove($ventes);
            $entityManager->flush();
            $result = array("status"=> "OK", "data"=>$ventes->getNom()." Supprimer avec success" );
        } catch (\Exception $exception) {
            $result = array("status"=> "ERROR", "message"=>$exception->getMessage());
        }
        $response->setData($result);
        return $response;
    }
}
