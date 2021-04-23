<?php

namespace App\Purchase;

use App\Cart\CartService;
use DateTime;
use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class PurchasePersister
{
    protected $security;
    protected $cartService;
    protected $em;

    public function __construct(Security $security, CartService $cartService, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->cartService = $cartService;
        $this->em = $em;
    }

    public function storePurchase(Purchase $purchase)
    {


        $this->em->persist($purchase);


        // 7. Nous allons la lier avec les produits qui sont dans le panier (CartService)
        foreach ($this->cartService->getDetailedCartItems() as $cartItem) {
            $purchaseItem = new PurchaseItem;

            //dd($cartItem["picture"]->getName());

            $purchaseItem->setPurchase($purchase)

                ->setPicture($cartItem["picture"])

                ->setPictureName($cartItem['picture']->getName())
                ->setPicturePrice($cartItem['picture']->getPrice())

                ->setTotal($cartItem['picture']->getPrice());
            //dd($purchaseItem);

            // 6. Nous allons la lier avec l'utilisateur actuellement connecté (Security)
            $purchase->setUser($this->security->getUser())
                ->setTotal($cartItem['picture']->getPrice())
                ->setPurchasedAt(new DateTime);

            $this->em->persist($purchaseItem);
        }



        // 8. Nous allons enregistrer la commande (EntityManagerInterface)
        $this->em->flush();
    }
}
