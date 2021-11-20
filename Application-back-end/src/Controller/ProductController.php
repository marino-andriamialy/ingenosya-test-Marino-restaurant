<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProductFormType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * @Route("/add-product", name="add_product")
     */
    public function addProduct(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // ... do something
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute("products");
        }
        return $this->render("product/product-form.html.twig", [
            "form_title" => "Ajouter un produit",
            "form_product" => $form->createView(),
        ]);
    }

    /**
     * @Route("/products", name="products")
     */
    public function products()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->render('product/products.html.twig', [
            "products" => $products,
        ]);
    }

    /**
     * @Route("/product/{id}", name="product")
     */
    public function product(int $id): Response
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        return $this->render("product/product.html.twig", [
            "product" => $product,
        ]);
    }

    /**
     * @Route("/modify-product/{id}", name="modify_product")
     */
    public function modifyProduct(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $product = $entityManager->getRepository(Product::class)->find($id);
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            return $this->redirectToRoute("products");
        }

        return $this->render("product/product-form.html.twig", [
            "form_title" => "Modifier un produit",
            "form_product" => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete-product/{id}", name="delete_product")
     */
    public function deleteProduct(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute("products");
    }
}
