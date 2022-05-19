<?php

namespace App\Controller;

use App\Form\AdresseLivraisonType;
use App\Repository\UserRepository;
use App\Form\AdresseFacturationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdresseController extends AbstractController
{
    /**
     * @Route("/adresse", name="app_adresseliv")
     */
    public function livraison(Request $request, UserRepository $adresseliv): Response
    {

        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_connexion');
        }

        $formulaire = $this->createForm(AdresseLivraisonType::class,);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {

            $this->getUser()->setAdresseliv($formulaire->get('adresse')->getData());

            return $this->redirectToRoute('app_adressefact');
        }

        return $this->render('adresse/index.html.twig', [
            'titre' => 'Nouvelle adresse',
            'form' => $formulaire->createView()
        ]);
    }
    /**
     * @Route("/adresse/fact", name="app_adressefact")
     */
    public function facturation(Request $request, UserRepository $adressefact): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_connexion');
        }
        $formulaire = $this->createForm(AdresseFacturationType::class,);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $this->getUser()->setAdressefact($formulaire->get('adresse')->getData());
            return $this->redirectToRoute('app_recap');
        }

        return $this->render('adresse/fact.html.twig', [
            'titre' => 'adresse facturation',
            'form' => $formulaire->createView()
        ]);
    }
}
