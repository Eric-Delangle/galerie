<?php

namespace App\Controller;

use App\Entity\Encours;
use App\Repository\EncoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/encours")
 */
class EncoursController extends AbstractController
{
    /**
     * @Route("/encours", name="encours_index", methods={"GET"})
     */
    public function index(EncoursRepository $encoursRepository): Response
    {
        return $this->render('encours/index.html.twig', [
            'encours' => $encoursRepository->findAll(),
        ]);
    }

    /**
     * @Route("/encours/{slug}", name="encours_show", methods={"GET"})
     */

    public function show(Encours $encour): Response
    {
        return $this->render('encours/show.html.twig', [
            'encour' => $encour,
        ]);
    }
}
