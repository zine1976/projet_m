<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ImageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $Pouf;

    /**
     * @ORM\Column(type="text")
     */
    private $Lampe;

    /**
     * @ORM\Column(type="text")
     */
    private $Theiere;

    /**
     * @ORM\Column(type="text")
     */
    private $Khol;

    /**
     * @ORM\Column(type="text")
     */
    private $Deco;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPouf(): ?string
    {
        return $this->Pouf;
    }

    public function setPouf(string $Pouf): self
    {
        $this->Pouf = $Pouf;

        return $this;
    }

    public function getLampe(): ?string
    {
        return $this->Lampe;
    }

    public function setLampe(string $Lampe): self
    {
        $this->Lampe = $Lampe;

        return $this;
    }

    public function getTheiere(): ?string
    {
        return $this->Theiere;
    }

    public function setTheiere(string $Theiere): self
    {
        $this->Theiere = $Theiere;

        return $this;
    }

    public function getKhol(): ?string
    {
        return $this->Khol;
    }

    public function setKhol(string $Khol): self
    {
        $this->Khol = $Khol;

        return $this;
    }

    public function getDeco(): ?string
    {
        return $this->Deco;
    }

    public function setDeco(string $Deco): self
    {
        $this->Deco = $Deco;

        return $this;
    }
}
