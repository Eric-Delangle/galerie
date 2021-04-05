<?php

namespace App\Entity;

use App\Repository\PurchaseItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PurchaseItemRepository::class)
 */
class PurchaseItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pictureName;

    /**
     * @ORM\Column(type="integer")
     */
    private $picturePrice;


    /**
     * @ORM\Column(type="integer")
     */
    private $total;


    /**
     * @ORM\ManyToOne(targetEntity=Picture::class, inversedBy="purchaseItems")
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity=Purchase::class, inversedBy="purchaseItems")
     */
    private $purchase;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getPictureName(): ?string
    {
        return $this->pictureName;
    }

    public function setPictureName(string $pictureName): self
    {
        $this->pictureName = $pictureName;

        return $this;
    }

    public function getPicturePrice(): ?int
    {
        return $this->picturePrice;
    }

    public function setPicturePrice(int $picturePrice): self
    {
        $this->picturePrice = $picturePrice;

        return $this;
    }


    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getPicture(): ?Picture
    {
        return $this->picture;
    }

    public function setPicture(?Picture $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPurchase(): ?Purchase
    {
        return $this->purchase;
    }

    public function setPurchase(?Purchase $purchase): self
    {
        $this->purchase = $purchase;

        return $this;
    }
}
