<?php

namespace App\Cart;

use App\Entity\Picture;

class CartItem
{
    public $picture;

    public function __construct(Picture $picture)
    {
        $this->picture = $picture;
    }

    public function getTotal(): int
    {
        return $this->picture->getPrice();
    }
}
