<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Repas;
use App\Entity\RepasMenus;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManagerInterface;
class RepasController extends AbstractController
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/repas", name="repas")
     */
    public function index(): Response
    {
        return $this->render('repas/index.html.twig', [
            'controller_name' => 'RepasController',
        ]);
    }

    /**
     * @Route("/repas/{id}", name="repa")
     */
    public function repa(int $id): Response
    {
        $qb = $this->entityManager->createQueryBuilder();
        $response = new JsonResponse();
        // $Repas = $this->getDoctrine()->getRepository(Repas::class)->findAll();
        try{
            $qb->add('select', 'u')
                ->add('from', 'App:Repas u')
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
     * @Route("/tout-repa", name="all_repa")
     */
    public function toutRepa()
    {
        $qb = $this->entityManager->createQueryBuilder();
        $response = new JsonResponse();
        // $Repas = $this->getDoctrine()->getRepository(Repas::class)->findAll();
        try{
            $qb->add('select', 'u')
                ->add('from', 'App:Repas u')
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
     * @Route("/tout-repas-menu/{id}", name="all_repas_menu")
     */
    public function toutMenusRepas(int $id)
    {
        $response = new JsonResponse();
        // $Menus = $this->getDoctrine()->getRepository(Menus::class)->findAll();
        try{
            $query = $this->entityManager
            ->createQuery("SELECT u.id, u.menusQuantite as quantite, u.menuId, u.repasId, a.nom, a.prixUnitaire
            FROM App:RepasMenus u 
            JOIN App:Menus a 
            WHERE a.id = u.menuId
            AND u.repasId = :identifier");
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
     * @param int id repas
     * @Route("/tout-repas-menu-ingredient/{id}", name="all_repas_menu_ing")
     */
    public function toutMenusRepasIngredients(int $id)
    {
        $response = new JsonResponse();
        // $Menus = $this->getDoctrine()->getRepository(Menus::class)->findAll();
        try{
            $query = $this->entityManager
            ->createQuery("SELECT u.id, u.menusQuantite as quantite, u.menuId, u.repasId, a.nom, a.prixUnitaire
            FROM App:RepasMenus u 
            JOIN App:Menus a 
            WHERE a.id = u.menuId
            AND u.repasId = :identifier");
            $query->setParameter('identifier', $id);
            $RepasMenus = $query->getArrayResult();
            
            $arrayAll = [];
            foreach($RepasMenus as $RepasMenu){
                $query = $this->entityManager
                ->createQuery("SELECT u.id, u.ingredientQuantite * :nultiplier
                as quantite, a.nom, a.unite, a.stock, u.ingredientId
                FROM App:MenusIngredients u 
                JOIN App:Ingredients a 
                WHERE a.id = u.ingredientId
                AND u.menusId = :identifier");
                $query->setParameter('identifier', $RepasMenu["menuId"]);
                $query->setParameter('nultiplier', $RepasMenu["quantite"]);
                $result = $query->getArrayResult();
                array_push($arrayAll, ...$result);
            }

            $arrayUnique =[];
            foreach($arrayAll as $data){
                if (array_key_exists($data["nom"], $arrayUnique)) {
                    $arrayUnique[$data["nom"]]["quantite"] = number_format(floatval($arrayUnique[$data["nom"]]["quantite"]) + floatval($data["quantite"]), 2, '.', ',');
                }else{
                    $arrayUnique[$data["nom"]] = $data;
                }
            }
            
            $arrayReturn = [];
            foreach($arrayUnique as $key => $value){
                array_push($arrayReturn ,$value);
            }

            $response->setData($arrayReturn);
        } catch (\Exception $exception) {
            $result = array("status"=> "ERROR", "message"=>$exception->getMessage());
            $response->setData($result);
        }

        return $response;
    }

     /**
     * @Route("/add-repa", name="add_repa", methods={"POST"})
     */
    public function addRepa(Request $request): Response
    {
        $response = new JsonResponse();
        $entityManager = $this->getDoctrine()->getManager();
        $repas = new Repas();
        try{
            $dataPost = json_decode($request->getContent(), true); 
            $repas->setNom($dataPost["repa"]["nom"]);
            $today = date("yy-m-d H:i:s");
            $repas->setCreerLe(new \DateTime($today));
            $repas->setPrix($dataPost["repa"]["prix"]);
            $entityManager->persist($repas);
            $entityManager->flush();

            foreach($dataPost["menu"] as $menu){
                $repasMenus = new repasMenus();
                $repasMenus->setRepasId($repas->getId());
                $repasMenus->setMenuId($menu["menuId"]);
                $repasMenus->setMenusQuantite($menu["quantite"]);
                $entityManager->persist($repasMenus);
                $entityManager->flush();
            }
            
            $result = $dataPost;
           // $result = array("status"=> "OK", "data"=>$dataPost);
        } catch (\Exception $exception) {
            $result = array("status"=> "ERROR", "message"=>$exception->getMessage());
        }
        $response->setData($result);
        return $response;
    }

    /**
     * @Route("/modify-repa", name="modify_repa", methods={"POST", "PUT"})
     */
    public function modifyRepa(Request $request): Response
    {
        $response = new JsonResponse();
        $entityManager = $this->getDoctrine()->getManager();
        
        try{
            $dataPost = json_decode($request->getContent(), true); 
            $repas = $this->getDoctrine()->getRepository(Repas::class)->find($dataPost["repa"]["id"]);
           
            $repas->setNom($dataPost["repa"]["nom"]);
            $repas->setPrix($dataPost["repa"]["prix"]);
            $entityManager->persist($repas);
            $entityManager->flush();
            foreach($dataPost["menu"] as $menuRepas){
                if(isset($menuRepas['id'])){

                    $repasMenus = $this->getDoctrine()->getRepository(repasMenus::class)->find($menuRepas["id"]);
                    $repasMenus->setRepasId($repas->getId());
                    $repasMenus->setMenuId($menuRepas["menuId"]);
                    $repasMenus->setMenusQuantite($menuRepas["quantite"]);
                    $entityManager->persist($repasMenus);
                    $entityManager->flush();
                    
                }else{
                    $repasMenus = new repasMenus();
                    $repasMenus->setRepasId($repas->getId());
                    $repasMenus->setMenuId($menuRepas["menuId"]);
                    $repasMenus->setMenusQuantite($menuRepas["quantite"]);
                    $entityManager->persist($repasMenus);
                    $entityManager->flush();
                }
            }
            $result = $dataPost;
            //$result = array("status"=> "OK", "data"=>$dataPost);
        } catch (\Exception $exception) {
            $result = array("status"=> "ERROR", "message"=>$exception->getMessage());
        }
        $response->setData($result);
        return $response;
    }

    /**
     * @Route("/delete-repa/{id}", name="delete_repa")
     */
    public function deleteRepa(int $id): Response
    {
        $response = new JsonResponse();
        try{
            $entityManager = $this->getDoctrine()->getManager();
            $repas = $this->getDoctrine()->getRepository(Repas::class)->find($id);
            $entityManager->remove($repas);
            $entityManager->flush();
            $result = array("status"=> "OK", "data"=>$repas->getNom()." Supprimer avec success" );
        } catch (\Exception $exception) {
            $result = array("status"=> "ERROR", "message"=>$exception->getMessage());
        }
        $response->setData($result);
        return $response;
    }
}
