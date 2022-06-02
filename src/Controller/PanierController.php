<?php

namespace App\Controller;

use App\Classe\Panier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

 /**
  * @IsGranted("ROLE_USER")
  * @Route("/panier")
  */
class PanierController extends AbstractController
{
    
         // j'ai besoin de l'entity manager pour recuperer les données des produits
         private $entityManager;
    
         public function __construct(EntityManagerInterface $entityManager)
         {
             $this->entityManager = $entityManager;
         }
    
         /**
          * @route("/mon-panier", name="app_panier")
          */
         public function index(Panier $panier)
         {
             return $this->render('panier/index.html.twig', [
                'panier' => $panier->getMyPanier(),
    
         ]);
     }
    
     /**
      * @route("/panier/add/{id}", name="add_panier")
      */
     public function incremente(Panier $panier, $id)
     {         // j'ajoute un produit grace à son id
         $panier->add($id);
    
             return $this->redirectToRoute('app_panier');
        }
    
         /**
          * @route("/panier/decremente/{id}", name="decremente_panier")
          */
         public function decremente(Panier $panier, $id)
         {
             // j'enleve un produit grace à son id
             $panier->decremente($id);
    
            return $this->redirectToRoute('app_panier');
         }
    
         /**
          * @route("/panier/remove", name="remove_panier")
          */
         public function suppression(Panier $panier)
         {
             // Je vide le panier
             $panier->remove();
             return $this->redirectToRoute('app_accueil');
         }
    
         /**
          * @route("/panier/del/{id}", name="del_ligne-panier")
          */
         public function suppLigne(Panier $panier, $id)
         {
             // Je supprime la ligne du panier
             $panier->delete($id);
             return $this->redirectToRoute('app_panier');
         }
    
        // /**
        //  * @Route("/choix", name="choix")
        //  */
        // public function choix(Panier $panier)
        // {
    
        //     return $this->render('panier/panierbis.html.twig', [
        //         'panier' => $panier->getMyPanier(),
    
        //     ]);
        // }
    
        /**
         * @Route("/recap", name="app_recap")
         */
        public function recap()
        {
            return $this->render('panier/recap.html.twig');
        }
    }
    