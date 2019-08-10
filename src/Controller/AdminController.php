<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Manager\CategoryManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [

        ]);
    }

    /**
     * @Route("/admin/categories", name="admin_categories")
     */
    public function categories(Request $request, CategoryManager $manager)
    {
        $newCategory = new Category();

        $form = $this->createForm(CategoryType::class, $newCategory);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->saveCategory($newCategory);
        }

        $categories = $manager->getAllCategories();

        return $this->render('admin/categories.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories,
        ]);
    }


    // Je ne récupère pas directement la catégorie dans les paramètres de la fonction car ça me donnait ce message d'erreur :
    // Cannot autowire argument $category of "App\Controller\AdminController::category()": it references class "App\Entity\Category" but no such service exists.
    // Donc je récupère l'ID, puis je récupère manuellement la catégorie en fonction de l'ID que je reçois
    /**
     * @Route("/admin/categories/{id}", name="admin_categories_id")
     */
    public function category(int $id, CategoryManager $manager)
    {
        $category = $manager->getCategoryById($id);

        if(is_null($category)) {
            throw new NotFoundHttpException();
        }

        dd($category);

        return;
    }

    /**
     * @Route("/admin/categories/{id}/delete", name="admin_categories_id_delete")
     */
    public function deleteCategory(int $id, CategoryManager $manager)
    {
        $category = $manager->getCategoryById($id);

        if(is_null($category)) {
            throw new NotFoundHttpException();
        }

        $manager->deleteCategory($category);

        return $this->redirectToRoute('admin_categories');
    }
}
