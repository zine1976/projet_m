<?php

namespace App\Classe;

use App\Repository\CategorieRepository;

class Categorie
{
    private $categorieRepository;

    public function __construct(CategorieRepository $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;
    }

    public function getCategories()
    {
        $categories = $this->categorieRepository->findAll();
    }
}