<?php

namespace App\Cart;

use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService extends AbstractController
{
    protected $session;
    protected $pictureRepo;

    public function __construct(SessionInterface $session, PictureRepository $pictureRepo)
    {
        $this->session = $session;
        $this->pictureRepo = $pictureRepo;
    }

    protected function getCart(): array
    {
        return $this->session->get('cart', []);
    }

    protected function saveCart(array $cart)
    {
        $this->session->set('cart', $cart);
    }

    public function empty()
    {
        $this->saveCart([]);
    }

    public function add(int $id)
    {
        // retrouver le panier dans la session (sous forme de tableau)
        // si pas de panier en prendre un vide
        $cart = $this->session->get('cart', []);

        // voir si le produit($id) existe déja dans le tableau
        if (array_key_exists($id, $cart)) {
            $this->addFlash('danger', 'Vous avez déjà craqué pour cette œuvre.');
            // dans le cas d'articles multiple on augmenter la quantité : $cart[$id]++;
        } else {

            $cart[$id] = 1;
            $this->addFlash('success', 'Cette œuvre est bien dans votre panier');
        }

        // enregistrer le panier mis a jour dans la session 
        $this->session->set('cart', $cart);
        //$request->getSession()->remove('cart');
    }


    public function remove(int $id)
    {
        $cart = $this->getCart();

        unset($cart[$id]);

        $this->saveCart($cart);
    }

    public function decrement(int $id)
    {
        $cart = $this->getCart();

        if (!array_key_exists($id, $cart)) {
            return;
        }

        // Soit le produit est à 1 alors il faut simplement le supprimer
        if ($cart[$id] === 1) {
            $this->remove($id);
            return;
        }

        // Soit le produit est à plus de 1, alors il faut décrémenter;
        $cart[$id]--;

        $this->saveCart($cart);
    }

    public function getTotal(): int
    {
        $total = 0;

        foreach ($this->session->get('cart', []) as $id => $name) {

            $toile = $this->pictureRepo->find($id);
            $total += $toile->getPrice() / 10;
        }
        return $total;
    }

    /**
     * @return CartItem[]
     */
    public function getDetailedCartItems(): array
    {
        $detailedCart = [];

        foreach ($this->session->get('cart', []) as $id => $name) {

            $toile = $this->pictureRepo->find($id);
            $detailedCart[] = [
                "picture" => $toile,
                'name' => $name
            ];
        }
        return $detailedCart;
    }
}
