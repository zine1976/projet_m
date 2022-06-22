<?php

namespace App\Controller;

use DateTime;
use Stripe\Stripe;
use App\Classe\Panier;
use App\Entity\Commande;
use App\Service\PdfService;
use Stripe\Checkout\Session;
use App\Entity\CommandeProduit;
use Doctrine\ORM\EntityManager;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use App\Repository\EtatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/payment")
 */
class PaymentController extends AbstractController
{
    /**
     * @Route("/payment/{token}", name="app_payment")
     */
       
    public function index($token, EntityManagerInterface $entityManager, Panier $panier)
    {

        $for_stripe = [];
        $YOUR_DOMAIN = 'http://localhost:3000/public';

        $commande = $entityManager->getRepository(Commande::class)->findOneBy(array('token' => $token));


        //Je boucle sur les entrées de mon panier
        foreach ($commande->getCommandeProduits()->getValues() as $produit) {
            // Je transmet la quantité et le prix des produits à stripe
            $for_stripe[] = [

                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $produit->getPrix() *100,
                    'product_data' => [
                        'name' => $produit->getProduit(),
                    ],
                ],
                'quantity' => $produit->getQuantite(),
            ];
        }
        // Je transmet le nom et le prix de la livraison
        $for_stripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $commande->getTransportPrix() * 100,
                'product_data' => [
                    'name' => $commande->getTransportNom(),
                ],
            ],
            'quantity' => 1,
        ];
Stripe::setApiKey($this->getParameter('stripeSecretKey'));

        $checkout_session = Session::create([
            // Je preremplis le champ email de l'utilisateur
            'customer_email' => $this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [
                $for_stripe
            ],
            'mode' => 'payment',
            // Les redirections en cas de echec ou success de paiement
            'success_url' => $this->generateUrl('app_payment_success', ['token' => $commande->getToken()], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' =>  $this->generateUrl('app_payment_cancel', ['token' => $commande->getToken()], UrlGeneratorInterface::ABSOLUTE_URL),

        ]);


        return $this->redirect($checkout_session->url);
    }
    

    /**
     * @Route("/success/{token}", name="app_payment_success")
     */
    public function success($token,  SessionInterface $session, CommandeRepository $cr, EtatRepository $etatRepository): Response
    {
        $etat = $etatRepository->find(2);
        $commande = $cr->findOneBy([
            'token' => $token,

        ]);

        if (empty($commande)) throw new AccessDeniedHttpException;

        $session->set('panier', []);
        $commande->setEtat($etat);
        $cr->add($commande);

        return $this->render('payment/success.html.twig');

    }

    /**
     * @Route("/cancel", name="app_payment_cancel")
     */
    public function cancel()
    {
        return $this->render('payment/cancel.html.twig');
    }
  
}
