<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Repository\PictureRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/")
 */
class PictureController extends AbstractController
{
    /**
     * @Route("/picture", name="picture_index", methods={"GET"})
     */
    public function index(PictureRepository $pictureRepository): Response
    {

        return $this->render('picture/index.html.twig', [
            'pictures' => $pictureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/picture/{slug}", name="picture_show", methods={"GET"})
     */
    public function show(Picture $picture): Response
    {
        return $this->render('picture/show.html.twig', [
            'picture' => $picture,
        ]);
    }
}
