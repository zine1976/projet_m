<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="app_accueil")
     */
    public function index(ProduitRepository $produitRepo, CategorieRepository $categorieRepo): Response
    {
        $categories = $categorieRepo->findAll();
        $derniersProduits = $produitRepo->findBy([], ['id' => 'DESC'], 5);

        return $this->render('accueil/index.html.twig',
         [
            'controller_name' => 'AccueilController',
            'categories' => $categories,
            'derniersProduits' => $derniersProduits
        ]);
    }
      /**
     * @Route("/reglement", name="app_reglement")
     */
    public function reglement(): Response
    {
        return $this->render('accueil/reglement.html.twig',
         [
            'controller_name' => 'AccueilController',
        ]);
    }
        /**
     * @Route("/cgu", name="app_cgu")
     */
    public function cgu(): Response
    {
        return $this->render('accueil/cgu.html.twig',
         [
            'controller_name' => 'AccueilController',
        ]);
    }
    /**
     * @Route("/modal", name="app_modal")
     */
    public function modal(): Response
    {
        return $this->render('accueil/modal.html.twig',
         [
            'controller_name' => 'AccueilController',
        ]);
    }
       /**
     * @Route("/retour", name="app_retour")
     */
    public function retour(): Response
    {
        return $this->render('accueil/retour.html.twig',
         [
            'controller_name' => 'AccueilController',
        ]);
    }
        /**
     * @Route("/essai", name="app_essai")
     */
    public function essai(): Response
    {
        return $this->render('accueil/essai.html.twig',
         [
            'controller_name' => 'AccueilController',
        ]);
    }
}
