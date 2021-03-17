<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMemberController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function adminIndex(): Response
    {
        return $this->render('admin/adminIndex.html.twig', []);
    }
}
