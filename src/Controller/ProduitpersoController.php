<?php

namespace App\Controller;

use DateTime;
use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitpersoController extends AbstractController
{
    /**
     * @Route("/produitperso", name="app_produit")
     */
    public function index(ProduitRepository $produit): Response
    {
        $produits = $produit->findAll();

        return $this->render('produitperso/index.html.twig', [
            'produit' => $produits,

        ]);
    }
    /**
     * @Route("/produitperso/indexdetail{id}", name="app_detailproduit")
     */
    public function detailproduit($id, Request $request, ProduitRepository $produit): Response
    {
        $produits = $produit->findOneBy([
            'id' => $id
        ]);
 // Partie commentaires
        // On crée le commentaire "vierge"
        $comment = new Comments;

        // On génère le formulaire
        $commentForm = $this->createForm(CommentsType::class, $comment);

        $commentForm->handleRequest($request);

        // Traitement du formulaire
        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $comment->setCreatedAt(new DateTime());
            $comment->setProduits($produits);

            // On récupère le contenu du champ parentid
            $parentid = $commentForm->get("parentid")->getData();

            // On va chercher le commentaire correspondant
            $em = $this->getDoctrine()->getManager();

            if($parentid != null){
                $parent = $em->getRepository(Comments::class)->find($parentid);
            }

            // On définit le parent
            $comment->setParent($parent ?? null);

            $em->persist($comment);
            $em->flush();

            $this->addFlash('message', 'Votre commentaire a bien été envoyé');
            return $this->redirectToRoute('app_detailproduit', ['id' => $produits->getId()]);
            // return $this->redirectToRoute('app_produit');

        }

        return $this->render('produitperso/indexdetail.html.twig', [
            'produit' => $produits,
            'commentForm' => $commentForm->createView()
        ]);


    }
   
   
}
