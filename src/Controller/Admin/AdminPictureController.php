<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use App\Form\PictureType;
use Cocur\Slugify\Slugify;
use App\Repository\PictureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/picture")
 */
class AdminPictureController extends AbstractController
{
    /**
     * @Route("/admin/picture", name="admin_picture_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminPictureIndex(PictureRepository $pictureRepository): Response
    {

        return $this->render('admin/picture/index.html.twig', [
            'pictures' => $pictureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/picture/new", name="picture_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $picture = new Picture();
        $slugify = new Slugify();
        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $slug = $slugify->slugify($picture->getName());
            $picture->setSlug($slug);
            $picture->setCreatedAt(new \DateTime());
            $picture->setUpdatedAt(new \DateTime());
            $entityManager->persist($picture);
            $entityManager->flush();

            return $this->redirectToRoute('picture_index');
        }

        return $this->render('admin/picture/new.html.twig', [
            'picture' => $picture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/picture/{id}", name="picture_show", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(Picture $picture): Response
    {
        return $this->render('admin/picture/show.html.twig', [
            'picture' => $picture,
        ]);
    }

    /**
     * @Route("/picture/{id}/edit", name="picture_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Picture $picture): Response
    {
        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('picture_index');
        }

        return $this->render('admin/picture/edit.html.twig', [
            'picture' => $picture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/picture/{id}", name="picture_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Picture $picture): Response
    {
        if ($this->isCsrfTokenValid('delete' . $picture->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($picture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('picture_index');
    }
}
