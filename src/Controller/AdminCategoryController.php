<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    #[Route('/admin/category', name: 'app_admin_category')]
    public function index(): Response
    {
        return $this->render('admin_category/index.html.twig', [
            'controller_name' => 'AdminCategoryController',
        ]);
    }


    #[Route("/gestion/afficher", name: "category_afficher")]
    public function category_afficher(CategoryRepository $repoCategory)
    {
        $categories = $repoCategory->findAll();//SELECT * FROM category
        return $this->render("admin_category/category_afficher.html.twig",[
            "categories" => $categories
        ]);
    }
}
