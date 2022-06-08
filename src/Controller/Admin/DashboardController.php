<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\Comments;
use App\Entity\Categorie;
use App\Repository\UserRepository;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use App\Repository\CommentsRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{

    protected $userRepository;
    protected $commandeRepository;
    protected $produitRepository;
    protected $commentsRepository;
    protected $categorieRepository;



    public function __construct(
        UserRepository $userRepository,
        CommandeRepository $commandeRepository,
        ProduitRepository $produitRepository,
        CommentsRepository $commentsRepository,
        CategorieRepository $categorieRepository


    ) {
        $this->userRepository = $userRepository;
        $this->commandeRepository = $commandeRepository;
        $this->produitRepository = $produitRepository;
        $this->commentsRepository = $commentsRepository;
        $this->categorieRepository = $categorieRepository;

    }
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {

           return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
            'countUser' => $this->userRepository->countAllUser(),
            'countCommande' => $this->commandeRepository->countAllCommande(),
            'produits' => $this->produitRepository->findAll()
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Projet M');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil', 'fa fa-home');
        yield MenuItem::linkToCrud('Produit', 'fas fa-list', Produit::class);
        yield MenuItem::linkToCrud('Commande', 'fas fa-list', Commande::class);
        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Comments', 'fas fa-list', Comments::class);
        yield MenuItem::linkToCrud('Categorie', 'fas fa-list', Categorie::class);

        yield MenuItem::linkToRoute('retour au site', 'fa fa-home', 'app_accueil');

        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
