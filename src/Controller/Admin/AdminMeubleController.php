<?php

namespace App\Controller\Admin;

use App\Entity\Meuble;
use App\Form\MeubleType;
use App\Repository\MeubleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/meuble")
 */
class AdminMeubleController extends AbstractController
{
    /**
     * @Route("/admin/meuble", name="admin_meuble_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(MeubleRepository $meubleRepository): Response
    {
        return $this->render('admin/meuble/index.html.twig', [
            'meubles' => $meubleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/meuble/new", name="admin_meuble_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $meuble = new Meuble();
        $form = $this->createForm(MeubleType::class, $meuble);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $name = $meuble->getName();
            $meuble->setCreatedAt(new \DateTime());
            $meuble->setUpdatedeAt(new \DateTime());
            $meuble->setSlug($name);
            $entityManager->persist($meuble);
            $entityManager->flush();

            return $this->redirectToRoute('admin_meuble_index');
        }

        return $this->render('admin/meuble/new.html.twig', [
            'encour' => $meuble,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/meuble/{id}", name="admin_meuble_show", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */

    public function show(Meuble $meuble): Response
    {
        return $this->render('admin/meuble/show.html.twig', [
            'meuble' => $meuble,
        ]);
    }

    /**
     * @Route("/admin/meuble/{id}/edit", name="admin_meuble_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Meuble $meuble): Response
    {
        $form = $this->createForm(MeubleType::class, $meuble);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_meuble_index');
        }

        return $this->render('admin/meuble/edit.html.twig', [
            'meuble' => $meuble,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/meuble/{id}", name="admin_meuble_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Meuble $meuble): Response
    {
        if ($this->isCsrfTokenValid('delete' . $meuble->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($meuble);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_meuble_index');
    }
}
