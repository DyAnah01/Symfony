<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;

class AdminCategoryController extends AbstractController
{
    #[Route('/admin/category', name:'app_admin_category')]
    public function index(): Response
    {
        return $this->render('admin_category/index.html.twig',[
            'controller_name' => 'AdminCategoryController',
        ]);
    }



    #[Route("/gestion/afficher", name:"category_afficher")]
    public function category_afficher(CategoryRepository $repoCategory)
    {
        $categories = $repoCategory->findAll();//SELECT * FROM category
        return $this->render("admin_category/category_afficher.html.twig",[
            "categories" => $categories
        ]);
    }


    #[Route("/gestion/ajouter", name: "category_ajouter")]
    public function category_ajouter(Request $request, EntityManagerInterface $manager)
    {

        // pour ajouter une entity, on a besoin de créer un nouvel objet issu de la class/entity Category
        $category = new Category;
        dump($category);
        /*
        pour créer un formulaire, on utilise la methode createForm()
        2 arguments obliogatoires :
        1-> class du formulaire
        2-> objet issu de la class/entity
        3-> facultatif : tableau
        */
        $form = $this->createForm(CategoryType::class, $category);
        // $form est un objet (qui contient ses methodes)

        $form->handleRequest($request);
        /*
        Pour traiter le formulaire on utilise la méthode handleRequest() dans lequel on injecte l’objet $request
        */

        /*
        Traitement du formulaire
        HandleRequest() premet de gérer le traitement de la saisie du formulaire.
        Lorsqu'on soumet le formulaire (bouton submit) $_POST est transmis à la même URL grâce à la request , on peut traiter le contenu de la requête
        */

        // si le formulaire a été soumis (clic sur le bouton de type="submit")
        // et si le formulaire a été validé (respect des conditions/contraintes)

        if($form->isSubmitted() && $form->isValid())
        {
            /*
            Si le formulaire a été soumis (l’utilisateur a cliqué sur le bouton submit) et si le formulaire est valide
            (placer des conditions/contraintes sur le formulaire, input non vide, entre xx et xx caractères etc...)
            */
            // dump($category);
            $manager->persist($category); //définir l'objet à envoyer
            $manager->flush(); //envoyer
            // dump($manager->flush());
            // dd($category);
            /*
            On utilise 2 méthodes de la class EntityManagerInterface:

            Persist() permet d’insérer ou de modifier
            C’est la propriété id qui permet de définir

            Flush() permet d’envoyer en base de données
            */
            $this->addFlash('succes', "La catégorie N°". $category->getId()."a bien été ajoutée");
            
            return $this->redirectToRoute("category_afficher");

        }


        return $this->render('admin_category/Category_ajouter.html.twig',[
            "formCategory" => $form->createView(),
            // dans l'objet form se trouve une methode createView permettant de créer la structure en html du formulaire
        ]);


    }

   #[Route('/gestion/modifier/{id}', name: "category_modifier")]
    public function category_modifier($id , CategoryRepository $repoCategory, Request $request , EntityManagerInterface $manager)
    {
        // dd($id);
        $category = $repoCategory->find($id);
        // dd($category);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $manager->persist($category);
            $manager->flush();

            $this->addFlash("succes", "La catégorie N°" . $category->getId() . "a bien été modifié");
            return $this->redirectToRoute('category_afficher');

        }

        return $this->render("admin_category/category_modifier.html.twig", [
            // dans l'objet form se trouve une methode createView permettant de créer la structure en html du formulaire
            "formCategory" => $form->createView(),
            "category"=> $category
        ]);

    }


}
