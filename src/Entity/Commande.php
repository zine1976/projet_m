<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

   

    /**
     * @ORM\Column(type="date")
     */
    private $datecom;

   

  

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\OneToMany(targetEntity=CommandeProduit::class, mappedBy="commande", cascade={"persist"})
     */
    private $commandeProduits;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commandes")
     * @ORM\JoinColumn(nullable=true, name="user_id", onDelete="SET NULL")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $TransportNom;

    /**
     * @ORM\Column(type="integer")
     */
    private $TransportPrix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Adressefact;

    public function __construct()
    {
        $this->commandeProduits = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getDateCom(): ?\DateTimeInterface
    {
        return $this->datecom;
    }

    public function setDateCom(\DateTimeInterface $datecom): self
    {
        $this->datecom = $datecom;

        return $this;
    }

   


    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return Collection<int, CommandeProduit>
     */
    public function getCommandeProduits(): Collection
    {
        return $this->commandeProduits;
    }

    public function addCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if (!$this->commandeProduits->contains($commandeProduit)) {
            $this->commandeProduits[] = $commandeProduit;
            $commandeProduit->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if ($this->commandeProduits->removeElement($commandeProduit)) {
            // set the owning side to null (unless already changed)
            if ($commandeProduit->getCommande() === $this) {
                $commandeProduit->setCommande(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
    public function numcom()
    {
        $numcom = $this->getId().''.$this->getUser()->getId().''.$this->getDateCom()->format('dmY');
    return $numcom;
    }

    public function getTransportNom(): ?string
    {
        return $this->TransportNom;
    }

    public function setTransportNom(string $TransportNom): self
    {
        $this->TransportNom = $TransportNom;

        return $this;
    }

    public function getTransportPrix(): ?int
    {
        return $this->TransportPrix;
    }

    public function setTransportPrix(int $TransportPrix): self
    {
        $this->TransportPrix = $TransportPrix;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getAdressefact(): ?string
    {
        return $this->Adressefact;
    }

    public function setAdressefact(string $Adressefact): self
    {
        $this->Adressefact = $Adressefact;

        return $this;
    }
    
}
