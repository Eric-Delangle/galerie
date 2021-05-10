<?php

namespace App\Controller;

use App\Entity\Meuble;
use App\Form\MeubleType;
use App\Repository\MeubleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/meuble")
 */
class MeubleController extends AbstractController
{
    /**
     * @Route("/", name="meuble_index", methods={"GET"})
     */
    public function index(MeubleRepository $meubleRepository): Response
    {
        return $this->render('meuble/index.html.twig', [
            'meubles' => $meubleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="meuble_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $meuble = new Meuble();
        $form = $this->createForm(MeubleType::class, $meuble);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($meuble);
            $entityManager->flush();

            return $this->redirectToRoute('meuble_index');
        }

        return $this->render('meuble/new.html.twig', [
            'meuble' => $meuble,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="meuble_show", methods={"GET"})
     */
    public function show(Meuble $meuble): Response
    {
        return $this->render('meuble/show.html.twig', [
            'meuble' => $meuble,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="meuble_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Meuble $meuble): Response
    {
        $form = $this->createForm(MeubleType::class, $meuble);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('meuble_index');
        }

        return $this->render('meuble/edit.html.twig', [
            'meuble' => $meuble,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="meuble_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Meuble $meuble): Response
    {
        if ($this->isCsrfTokenValid('delete' . $meuble->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($meuble);
            $entityManager->flush();
        }

        return $this->redirectToRoute('meuble_index');
    }
}
