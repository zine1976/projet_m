<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="app_produit")
     */
    public function index(ProduitRepository $produit): Response
    {
        $produits = $produit->findAll();

        return $this->render('produit/index.html.twig', [
            'produit' => $produits,

        ]);
    }
    /**
     * @Route("/produit/indexdetail{id}", name="app_detailproduit")
     */
    public function detailproduit($id, ProduitRepository $produit): Response
    {
        $produits = $produit->find($id);

        return $this->render('produit/indexdetail.html.twig', [
            'produit' => $produits,

        ]);
    }
    
   
}
 
