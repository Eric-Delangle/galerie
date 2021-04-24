<?php

namespace App\Controller;

use DateTime;
use App\Entity\Purchase;
use App\Cart\CartService;
use App\Form\PurchaseType;
use App\Form\CartConfirmationType;
use App\Purchase\PurchasePersister;
use App\Repository\PictureRepository;
use App\Repository\PurchaseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchaseController extends AbstractController
{

    protected $purchaseRepo;
    protected $persister;
    protected $cartservice;
    protected $pictureRepo;

    public function __construct(
        PurchaseRepository $purchaseRepo,
        PurchasePersister $persister,
        CartService $cartservice,
        PictureRepository $pictureRepo
    ) {
        $this->purchaserepo = $purchaseRepo;
        $this->purchaserepo = $pictureRepo;
        $this->persister = $persister;
        $this->cartservice = $cartservice;
    }

    /**
     * @Route("/purchase", name="purchase_list")
     */
    public function list(): Response
    {
        $toile = $this->pictureRepo->findAll();
        //dd($toile);
        $purchases = $this->purchaserepo->findAll();
        return $this->render('purchase/index.html.twig', [
            'purchases' => $purchases,
            'toile' => $toile
        ]);
    }

    /**
     * @Route("/purchase/new/{id}", name="purchase_new", methods={"GET","POST"})
     */
    public function new($id, Request $request)
    {

        $cart = $this->cartservice->getDetailedCartItems();
        $purchase = new Purchase();
        $this->persister->storePurchase($purchase);
        $form = $this->createForm(CartConfirmationType::class, $purchase);
        $form->handleRequest($request);


        return $this->render('purchase/payment.html.twig', [
            'cart' => $cart,
            'purchase' => $purchase,
            'form' => $form->createView(),
        ]);
    }
}
