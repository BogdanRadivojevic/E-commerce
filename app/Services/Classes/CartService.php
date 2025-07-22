<?php

namespace App\Services\Classes;

use App\Models\Order;
use App\Models\Product;
use App\Services\Interfaces\ICartService;
use Exception;
use Illuminate\Support\Facades\Auth;

class CartService implements ICartService
{
    /**
     * Dohvata trenutnu korpu korisnika ili kreira novu ako ne postoji.
     *
     * @return Order Korpa korisnika.
     */
    public function getCart()
    {
        // Pronalazi trenutnu korpu korisnika sa statusom 'pending'.
        $cart = Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        // Ako korpa ne postoji, kreira novu za korisnika.
        if (!$cart) {
            $cart = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
            ]);
        }

        return $cart;
    }

    /**
     * Dodaje proizvod u korpu ili ažurira količinu ako proizvod već postoji.
     *
     * @param int $product proizvod koji se dodaje.
     * @param int $quantity Količina proizvoda (default: 1).
     * @return Order Ažurirana korpa korisnika ili redirekcija sa greškom.
     * @throws Exception
     */
    public function addToCart($product, $quantity = 1)
    {
        $cart = $this->getCart(); // Dohvata trenutnu korpu korisnika.

        $product = Product::findOrFail($product);

        // Pronalazi proizvod u korpi koristeći find().
        $existingProduct = $cart->products()->find($product);

        $currentQuantityInCart = $existingProduct ? $existingProduct->pivot->quantity : 0;  // Ako proizvod ne postoji u korpi, inicijalizira se kolicina na 0

        $requestedQuantity = $currentQuantityInCart + $quantity;

        if ($product->stock < $requestedQuantity) {
            throw new \Exception("Insufficient stock for product: {$product->model}. Available: {$product->stock}, requested: {$requestedQuantity}.");
        }

        if ($existingProduct) {
            // Ažurira količinu proizvoda u pivot tabeli.
            $cart->products()->updateExistingPivot($product, [
                'quantity' => $existingProduct->pivot->quantity + $quantity,
            ]);

        } else {
            // Dodaje novi proizvod u korpu.
            $cart->products()->attach($product, ['quantity' => $quantity]);
        }

        $this->updateTotalPrice($cart);


        return $cart;
    }

    /**
     * Uklanja proizvod iz korpe.
     *
     * @param int $productId ID proizvoda koji se uklanja.
     * @return bool Indikacija da li je proizvod uspešno uklonjen.
     */
    public function removeFromCart($productId)
    {
        $cart = $this->getCart(); // Dohvata trenutnu korpu korisnika.

        // Koristi find() za pronalaženje proizvoda u pivot tabeli.
        $existingProduct = $cart->products()->find($productId);

        if ($existingProduct) {
            // Uklanja proizvod iz pivot tabele.
            $cart->products()->detach($productId);

            if ($this->isEmpty($cart)) {
                $this->setCartToCanceled($cart);
            }
            return true;
        }

        return false; // Proizvod nije pronađen u korpi.
    }

    /**
     * Završava kupovinu, menja status korpe u 'completed'.
     *
     * @return Order|bool Vraća završenu korpu ili false ako je prazna.
     * @throws Exception
     */
    public function completeCart()
    {

        $cart = $this->getCart(); // Dohvata trenutnu korpu korisnika.


        // Proverava da li korpa ima proizvode.
//        if ($cart->products()->count() == 0) {
        if ($this->isEmpty($cart)) {
            return false; // Korpa je prazna, završetak nije moguć.
        }

        $products = $cart->products()->get();

        $totalPrice = 0;

        foreach ($products as $product) {
            $totalPrice += $product->price * $product->pivot->quantity;

            // Decrement the product stock.
            if ($this->isStockAvailable($product)) {
                throw new Exception("Insufficient stock for product: {$product->model}");
            }

            $product->decrement('stock', $product->pivot->quantity);
        }

        // Menja status korpe u 'completed' i čuva promene.
        $cart->status = Order::STATUS_COMPLETED;
        $cart->total_price = $totalPrice;
        $cart->save();

        return $cart;
    }


    /**
     * @param $product
     * @return bool
     * @throws Exception
     */
    public function isStockAvailable($product)
    {
        if ($product->stock < $product->pivot->quantity) {
            return true;
        }
        return false;
    }


    /**
     * @param $cart
     * @return Order
     */
    public function setCartToCanceled($cart): Order
    {
        $cart->status = Order::STATUS_CANCELED;
        $cart->save();

        return $cart;
    }

    /**
     * @param Order $cart
     * @return bool
     */
    public function isEmpty($cart)
    {
        if ($cart->products()->count() === 0) {
            return true;
        }
        return false;
    }


    /**
     * @param Order $cart
     */
    private function updateTotalPrice(Order $cart)
    {
        $totalPrice = 0;
        foreach ($cart->products as $product) {
            $totalPrice += $product->price * $product->pivot->quantity;
        }

        $cart->total_price = $totalPrice;
        $cart->save();
    }

}
