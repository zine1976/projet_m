<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImageController extends AbstractController
{
    /**
     * @Route("/image", name="app_image")
     */
    public function image(ImageRepository $image): Response
    {
        $images = $image->findAll();
        return $this->render('image/index.html.twig', [
            'image' => $images,
        ]);
    }
    /**
     * @Route("/image/ajoutImage", name="app_ajoutImage")
     */
    public function ajoutImage(Request $request, ImageRepository $image): Response
    {
        $img = new Image;
        $formulaire = $this->createForm(ImageType::class, $img);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $image->add($img);
            return $this->redirectToRoute('app_produit');
        }

        return $this->render('image/ajoutImage.html.twig', [
            'titre' => 'Nouveau image',
            'form' => $formulaire->createView()
        ]);
    }
}
