<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\PdfService;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,


        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user);
            $session = new Session();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/user/donnees{id}", name="app_donnees_pdf", methods={"GET"})
     */
    public function facturePdfCommande($id, UserRepository $userRepository, PdfService $pdf)

    {


        $html = $this->render('user/donnees.html.twig', [
            'user' => $userRepository->findOneBy([
                'id' => $id,
            ]),

        ]);

        $pdf->showPdfFile($html);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/notverified/", name="app_notverified")
     */
    public function notVerified(UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {

        // Je vais chercher les users non verifiés
        $users = $userRepository->notVerifiedUser();
        // Le temps limite est de 2 heures, je boucle sur les users non verifiés et je les supprime de la bdd
        foreach ($users as $timelimit) {
            $entityManager->remove($timelimit);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Les users non vérifiés ont bien étés supprimés');
        return $this->redirectToRoute('app-accueil');
    }
}
