<?php

namespace App\Controller;

use App\Entity\Transport;
use App\Form\TransportType;
use App\Repository\TransportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/transport")
 */
class TransportController extends AbstractController
{
    /**
     * @Route("/", name="app_transport_index", methods={"GET"})
     */
    public function index(TransportRepository $transportRepository): Response
    {
        return $this->render('transport/index.html.twig', [
            'transports' => $transportRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_transport_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TransportRepository $transportRepository): Response
    {
        $transport = new Transport();
        $form = $this->createForm(TransportType::class, $transport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transportRepository->add($transport);
            return $this->redirectToRoute('app_transport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transport/new.html.twig', [
            'transport' => $transport,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_transport_show", methods={"GET"})
     */
    public function show(Transport $transport): Response
    {
        return $this->render('transport/show.html.twig', [
            'transport' => $transport,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_transport_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Transport $transport, TransportRepository $transportRepository): Response
    {
        $form = $this->createForm(TransportType::class, $transport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transportRepository->add($transport);
            return $this->redirectToRoute('app_transport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transport/edit.html.twig', [
            'transport' => $transport,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_transport_delete", methods={"POST"})
     */
    public function delete(Request $request, Transport $transport, TransportRepository $transportRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transport->getId(), $request->request->get('_token'))) {
            $transportRepository->remove($transport);
        }

        return $this->redirectToRoute('app_transport_index', [], Response::HTTP_SEE_OTHER);
    }
}
