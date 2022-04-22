<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    /**
     * @Route("/delete/{id}", name="app_delete")
     */
    public function indexProduit($id, ProduitRepository $prod): Response
    { $produit = $prod->find($id);

        
            $prod->remove($produit);
            $this->addFlash('success',   ' a été correctement supprimé.');
        //  else $this->addFlash('errors', 'On ne peut pas supprimer un produit');
        return $this->redirectToRoute('app_produit');
    

        
    }
}

   


