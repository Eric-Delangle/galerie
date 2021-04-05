<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Cart\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MemberController extends AbstractController
{

    /**
     * @Route("/member", name="member_account")
     */
    public function index(SessionInterface $session, CartService $cartservice): Response
    {
        $purchase = new Purchase();
        $detailedCart = $cartservice->getDetailedCartItems();
        $detailedCart = $cartservice->getDetailedCartItems();
        $total = $cartservice->getTotal();
        $user = $this->getUser();
        return $this->render('member/account.html.twig', [
            'items' => $detailedCart,
            'purchase' => $purchase,
            'cart' => $detailedCart,
            'total' => $total,
            'user' => $user
        ]);
    }
}
