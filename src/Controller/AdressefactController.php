<?php

namespace App\Controller;

use App\Entity\Adressefact;
use App\Form\AdressefactType;
use App\Repository\AdressefactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adressefact")
 */
class AdressefactController extends AbstractController
{
    /**
     * @Route("/", name="app_adressefact_index", methods={"GET"})
     */
    public function index(AdressefactRepository $adressefactRepository): Response
    {
        return $this->render('adressefact/index.html.twig', [
            'adressefacts' => $adressefactRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_adressefact_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AdressefactRepository $adressefactRepository): Response
    {
        $adressefact = new Adressefact();
        $form = $this->createForm(AdressefactType::class, $adressefact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adressefactRepository->add($adressefact);
            return $this->redirectToRoute('app_adressefact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adressefact/new.html.twig', [
            'adressefact' => $adressefact,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_adressefact_show", methods={"GET"})
     */
    public function show(Adressefact $adressefact): Response
    {
        return $this->render('adressefact/show.html.twig', [
            'adressefact' => $adressefact,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_adressefact_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Adressefact $adressefact, AdressefactRepository $adressefactRepository): Response
    {
        $form = $this->createForm(AdressefactType::class, $adressefact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adressefactRepository->add($adressefact);
            return $this->redirectToRoute('app_adressefact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adressefact/edit.html.twig', [
            'adressefact' => $adressefact,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_adressefact_delete", methods={"POST"})
     */
    public function delete(Request $request, Adressefact $adressefact, AdressefactRepository $adressefactRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adressefact->getId(), $request->request->get('_token'))) {
            $adressefactRepository->remove($adressefact);
        }

        return $this->redirectToRoute('app_adressefact_index', [], Response::HTTP_SEE_OTHER);
    }
}
