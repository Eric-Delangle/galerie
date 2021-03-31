<?php

namespace App\Controller;

use DateTime;
use App\Entity\Purchase;
use App\Cart\CartService;
use App\Form\PurchaseType;
use App\Repository\PictureRepository;
use App\Repository\PurchaseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchaseController extends AbstractController
{

    protected $purchaseRepo;

    public function __construct(PurchaseRepository $purchaseRepo)
    {
        $this->purchaserepo = $purchaseRepo;
    }

    /**
     * @Route("/purchase", name="purchase_list")
     */
    public function list(): Response
    {

        $purchases = $this->purchaserepo->findAll();
        return $this->render('purchase/index.html.twig', [
            'purchases' => $purchases,
        ]);
    }

    /**
     * @Route("/purchase/new/{id}", name="purchase_new", methods={"GET","POST"})
     */
    public function new(Request $request, PictureRepository $pictureRepo, $id, CartService $cartservice)
    {

        $cart = $cartservice->getDetailedCartItems();

        $user = $this->getUser();
        $picture = $pictureRepo->find($id);
        $purchase = new Purchase();
        $form = $this->createForm(PurchaseType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $purchase->setfullName('test');
            $purchase->setAddress($user->getAddress());
            $purchase->setPostalcode($user->getPostalcode());
            $purchase->setCity($user->getCity());
            $purchase->setTotal($picture->getPrice());
            $purchase->setStatus(Purchase::STATUS_PENDING);
            $purchase->setPurchasedAt(new DateTime());
            $purchase->setUser($user);
            dd($purchase);

            $entityManager->persist($purchase);
            $entityManager->flush();

            return $this->redirectToRoute('purchase_index');
        }

        return $this->render('purchase/new.html.twig', [
            'cart' => $cart,
            'purchase' => $purchase,
            'form' => $form->createView(),
        ]);
    }
}
