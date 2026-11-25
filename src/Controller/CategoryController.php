<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
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
    public function edit(EntityManagerInterface $em, Category $category): Response
    {

        // Modification
        $form = $this->createForm(CategoryType::class, $category);

        if(true) {
            return $this->render('category/show.html.twig', [
                'category' => $category
            ]);
        }        

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form
        ]);
    }
}
