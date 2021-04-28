<?php

namespace App\Controller\Admin;

use App\Entity\Encours;
use App\Form\EncoursType;
use App\Repository\EncoursRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/encours")
 */
class AdminEncoursController extends AbstractController
{
    /**
     * @Route("/admin/encours", name="admin_encours_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(EncoursRepository $encoursRepository): Response
    {
        return $this->render('admin/encours/index.html.twig', [
            'encours' => $encoursRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/encours/new", name="admin_encours_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $encour = new Encours();
        $form = $this->createForm(EncoursType::class, $encour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $name = $encour->getName();
            $encour->setCreatedAt(new \DateTime());
            $encour->setUpdatedAt(new \DateTime());
            $encour->setSlug($name);
            $entityManager->persist($encour);
            $entityManager->flush();

            return $this->redirectToRoute('admin_encours_index');
        }

        return $this->render('admin/encours/new.html.twig', [
            'encour' => $encour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/encours/{id}", name="admin_encours_show", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */

    public function show(Encours $encour): Response
    {
        return $this->render('admin/encours/show.html.twig', [
            'encour' => $encour,
        ]);
    }

    /**
     * @Route("/admin/encours/{id}/edit", name="admin_encours_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Encours $encour): Response
    {
        $form = $this->createForm(EncoursType::class, $encour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_encours_index');
        }

        return $this->render('admin/encours/edit.html.twig', [
            'encour' => $encour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/encours/{id}", name="admin_encours_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Encours $encour): Response
    {
        if ($this->isCsrfTokenValid('delete' . $encour->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($encour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_encours_index');
    }
}
