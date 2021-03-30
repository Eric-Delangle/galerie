<?php

namespace App\Controller;

use App\Cart\CartService;
use App\Repository\PictureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class CartController extends AbstractController
{
    /**
     * @Route("/cart/add/{id}", name="cart_add", requirements={"id":"\d+"})
     */
    public function add($id, Request $request, PictureRepository $pictureRepo, CartService $cartservice)
    {

        // securisation est ce que la toile existe ?
        $picture = $pictureRepo->find($id);

        if (!$picture) {
            $this->addFlash('danger', "Cette œuvre n'existe pas !");
        }

        $cartservice->add($id);

        return $this->redirectToRoute('picture_show', [
            'id' => $picture->getId(),
            'slug' => $picture->getSlug()
        ]);
    }

    /**
     * @Route("/cart", name="cart_show")
     */
    public function show(CartService $cartservice)
    {
        $detailedCart = $cartservice->getDetailedCartItems();
        $total = $cartservice->getTotal();

        return $this->render("cart/index.html.twig", [
            'items' => $detailedCart,
            'total' => $total
        ]);
    }

    /**
     * @Route("/cart/delete/{id}", name="cart_delete", requirements={"id":"\d+"})
     */
    public function delete($id, PictureRepository $pictureRepo, CartService $cartservice)
    {
        $toile = $pictureRepo->find($id);
        if (!$toile) {
            throw $this->createNotFoundException("La toile n° $id n'éxiste pas. Vous ne pouvez donc pas la supprimer.");
        }
        $cartservice->remove($id);
        $this->addFlash("success", "La toile est retirée de vos achats.");
        return $this->redirectToRoute("cart_show");
    }
}
