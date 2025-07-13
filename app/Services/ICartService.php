<?php

namespace App\Services;

interface ICartService
{
    public function getCart();

    public function addToCart($product, $quantity = 1);

    public function removeFromCart($productId);

    public function completeCart();

    function isStockAvailable($product);
}
