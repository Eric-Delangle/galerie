<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    /**
     * @Route("/member", name="member_account")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('member/account.html.twig', [
            'user' => $user
        ]);
    }
}
