<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category', methods: ['GET', 'HEAD'])]
    public function index(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(Category::class);
        $categories = $repository->findAll();

        //dd($categories);

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
    
    #[Route('/category/{id}', name: 'app_categorie_show', methods: ['GET'])]
    public function show(Category $category): Response
    {

        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/category/{id}', name: 'app_categorie_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $em, Category $category): Response
    {

        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute('app_category');
    }

    #[Route('/category/{id}', name: 'app_categorie_edit', methods: ['POST', 'PUT', 'PATCH'])]
    public function edit(EntityManagerInterface $em, Category $category, Request $request): Response
    {
        
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            // Modification
            $category = $form->getData();
            $em->flush();
            
            
            return $this->render('category/show.html.twig', [
                'category' => $category
            ]);
        }        

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form
        ]);
    }

    #[Route('/category/new', name: 'app_categorie_new', methods: ['GET', 'POST'])]
    public function new(EntityManagerInterface $em, Category $category, Request $request): Response
    {
        
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            // Modification
            $category = $form->getData();

            // Inseré dasn la base de donnée
            $em->persist($category);
            $em->flush();
            
            
            return $this->redirectToRoute('app_category');
        
        }        

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form
        ]);
    }
}
