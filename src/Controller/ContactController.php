<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {


        $formulaire = $this->createForm(ContactType::class);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $data = $formulaire->getData();

            // J'envoie mon mail
            $email = new TemplatedEmail;
            $email
                ->from('Contact projet_m <' . $data['email'] . '>')
                ->to('zine@ouazzanichahdi.com')
                ->replyTo($data['email'])
                ->subject('Vous avez une demande de contact.')
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'nom' => $data['nom'],
                    'prenom' => $data['prenom'],
                    'FromEmail' => $data['email'],
                    'message' => $data['message'],
                ]);


            $mailer->send($email);
            $this->addFlash('success', 'Message envoyé.');
        $formulaire = $this->createForm(ContactType::class);
        return $this->redirectToRoute('app_accueil');

        } 
            return $this->render('contact/formulaire.html.twig', [
                'titre' => 'Contact',
                'form' => $formulaire->createView()

            ]);

        }
    }

