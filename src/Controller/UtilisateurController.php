<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UtilisateurController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/utilisateur", name="app_utilisateur")
     */
    public function index(UtilisateurRepository $utilisateur): Response
    {

        $utilisateurs = $utilisateur->findAll();
        return $this->render('utilisateur/index.html.twig', [
            'utilisateur' => $utilisateurs,
        ]);
    }
     /**
     * @Route("/utilisateur/liste", name="app_utiliste")
     */
    public function liste(UtilisateurRepository $utilisateur): Response
    {

        $utilisateurs = $utilisateur->findAll();
        return $this->render('utilisateur/liste.html.twig', [
            'utilisateur' => $utilisateurs,
        ]);
    }
}
