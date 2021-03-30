<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MemberController extends AbstractController
{
    /**
     * @Route("/member", name="member_account")
     */
    public function index(SessionInterface $session): Response
    {

        // dd($session->getBag('attributes', 'cart'));
        $user = $this->getUser();
        return $this->render('member/account.html.twig', [
            'user' => $user
        ]);
    }
}
