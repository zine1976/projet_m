<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Commande;
use App\Entity\CommandeProduit;
use Stripe\Checkout\Session;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
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
     * @Route("/payment", name="app_payment")
     */
    public function index(SessionInterface $session, ProduitRepository $pr, CommandeRepository $cr, ManagerRegistry $mr): Response
    {
        $panier = $session->get('panier', []);

        Stripe::setApiKey($this->getParameter('stripeSecretKey'));

        if (empty($panier)) {
            $this->addFlash('error', 'Votre panier est vide, vous ne pouvez donc pas payer...');
            return $this->redirectToRoute('app_produit');
        }

        $ids = array_keys($panier);
        $produits = $pr->getAllProduits($ids);

        $commande = new Commande;
        $commande->setEtat('En cours');
        $commande->setToken(hash('sha256', random_bytes(32)));

        $commande->setDateCom(new DateTime);

        $line_items = [];

        foreach ($panier as $id => $quantite) {
            $produit = $produits[$id];
            $cp = new CommandeProduit;
            $cp->setQuantite($quantite);
            $cp->setProduit($produit);
            $commande->addCommandeProduit($cp);
            $line_items[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $produit->getNom(),
                        'images' => [$produit->getImage()] // Lien ABSOLU
                    ],
                    'unit_amount' => $produit->getPrix() * 100 // Montant en centimes
                ],
                'quantity' => $quantite,
            ];
        }


        $checkout = Session::create([
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => $this->generateUrl('app_payment_success', ['token' => $commande->getToken()], UrlGeneratorInterface::ABSOLUTE_URL), // Lien ABSOLU
            'cancel_url' => $this->generateUrl('app_payment_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL), // Lien ABSOLU
        ]);

        $cr->add($commande);

        return $this->redirect($checkout->url);
    }

    /**
     * @Route("/success/{token}", name="app_payment_success")
     */
    public function success($token, SessionInterface $session, CommandeRepository $cr): Response
    {
        $commande = $cr->findOneBy([
            'token' => $token
        ]);

        if (empty($commande)) throw new AccessDeniedHttpException;

        $session->set('panier', []);
        $commande->setEtat('Payée');
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
