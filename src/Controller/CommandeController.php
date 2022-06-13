<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Classe\Panier;
use App\Entity\Commande;
use App\Form\RegroupType;
use App\Form\CommandeType;
use App\Entity\CommandeProduit;
use App\Repository\UserRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/commande")
 */
class CommandeController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="app_commande_index", methods={"GET"})
     */
    public function index(CommandeRepository $commandeRepository): Response
    {
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_commande_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CommandeRepository $commandeRepository): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeRepository->add($commande);
            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_commande_show", methods={"GET"})
     */
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_commande_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeRepository->add($commande);
            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_commande_delete", methods={"POST"})
     */
    public function delete(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $commandeRepository->remove($commande);
        }

        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/commande/regroup", name="app_regroup")
     */
    public function regroup(Panier $panier, Request $request)
    {
        if (!$this->getUser()->getAdresses()->getValues()) {

            return $this->redirectToRoute('app_adresse_new');
        }
        if (!$this->getUser()->getAdressefacts()->getValues()) {

            return $this->redirectToRoute('app_adressefact_new');
        }

        $form = $this->createForm(RegroupType::class, null, [
            'user' => $this->getUser()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData());
        }

        return $this->render('commande/regroup.html.twig', [
            'panier' => $panier->getMyPanier(),
            'form' => $form->createView(),

        ]);
    }

     /**
      * @Route("/commande/recap", name="app_recap", methods={"GET", "POST"})
      */
      public function recap(Request $request, Panier $panier): Response
      {
         $form = $this->createForm(RegroupType::class, null, [
             'user' => $this->getUser()
         ]);
 
         $form->handleRequest($request);
 
         if ($form->isSubmitted() && $form->isValid()) {
 
             $dateCommande = new DateTime();
             $transport = $form->get('transport')->getData();
             $adresse = $form->get('Adresse')->getData();
             $adressefact = $form->get('Adressefact')->getData();
 
 
             // Je recupere les informations liés à la livraison
             $adresse_info = $adresse->getNomPrenom();
             $adresse_info .= '<br/>' . $adresse->getTel();
 
             if ($adresse->getSociete()) {
 
                 $adresse_info .= '<br/>' . $adresse->getSociete();
             }
             $adresse_info .= '<br/>' . $adresse->getNumero();
             $adresse_info .= '<br/>' .  $adresse->getRue();
 
             if ($adresse->getInfo()) {
 
                 $adresse_info .= '<br/>' . $adresse->getInfo();
             }
 
             $adresse_info .= '<br/>' . $adresse->getCp();
             $adresse_info .= '<br/>' . $adresse->getVille();
             $adresse_info .= '<br/>' . $adresse->getPays();
 //Je recupere toutes les information liés à la facturation
 
             $adressefact_info = $adresse->getNomPrenom();
             $adressefact_info .= '<br/>' . $adressefact->getTel();
 
             if ($adressefact->getSociete()) {
                 $adressefact_info .= '<br/>' . $adressefact->getSociete();
             }
             $adressefact_info .= '<br/>' . $adressefact->getNumero();
             $adressefact_info .= '<br/>' .  $adressefact->getRue();
 
             if ($adressefact->getInfo()) {
 
                 $adressefact_info .= '<br/>' . $adressefact->getInfo();
             }
             $adressefact_info .= '<br/>' . $adressefact->getCp();
             $adressefact_info .= '<br/>' . $adressefact->getVille();
             $adressefact_info .= '<br/>' . $adressefact->getPays();
 
 
             $commande = new Commande();
             $commande->setUser($this->getUser());
             $commande->setDateCom($dateCommande);
             $commande->setTransportNom($transport->getNom());
             $commande->setTransportPrix($transport->getPrix());
             $commande->setAdresse($adresse_info);
             $commande->setAdressefact($adressefact_info);
             $commande->setToken(hash('sha256', random_bytes(32)));
 //Je fige les données de commande
             $this->entityManager->persist($commande);
 
             foreach ($panier->getMyPanier() as $produit) {
                 $commandeProduit = new CommandeProduit;
                 $commandeProduit->setCommande($commande);
                 $commandeProduit->setProduit($produit['produit']);
                 $commandeProduit->setQuantite($produit['quantite']);
                 $commandeProduit->setPrix($produit['produit']->getPrix());
                 $commandeProduit->setTotal($produit['produit']->getPrix() * $produit['quantite']);
 
                 // je fige les données de commandeProduit
                 $this->entityManager->persist($commandeProduit);
             }
             // J'envoi tout en bdd
             $this->entityManager->flush();
 
             return $this->render('commande/recap.html.twig', [
                 'transport' => $transport,
                 'adresse' => $adresse,
                 'panier' => $panier->getMyPanier(),
                 'form' => $form->createView(),
                 'commande' => $commande,
             ]);
         }
         return $this->redirectToRoute('app_panier');
 
     }
}
