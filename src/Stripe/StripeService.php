<?php

namespace App\Stripe;

use App\Entity\Purchase;
use Symfony\Component\EventDispatcher\EventDispatcher;


class StripeService
{

    protected $secretKey;
    protected $publicKey;

    public function __construct(string $secretKey, string $publicKey)
    {
        $this->secretKey = $secretKey;
        $this->publicKey = $publicKey;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }


    public function getPaymentIntent(Purchase $purchase)
    {

        \Stripe\Stripe::setApiKey($this->secretKey);

        $prixencentimes = $purchase->getTotal() * 10;


        return \Stripe\PaymentIntent::create([
            "amount" => $prixencentimes,
            "currency" => "eur"
        ]);
    }
}
