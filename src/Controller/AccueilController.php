<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="app_accueil")
     */
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig',
         [
            'controller_name' => 'AccueilController',
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
    
}
