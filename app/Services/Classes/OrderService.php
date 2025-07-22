<?php

namespace App\Services\Classes;

use App\Models\Order;
use App\Services\Interfaces\IOrderService;
use Illuminate\Support\Facades\Auth;

class OrderService implements IOrderService
{
    /**
     * Dohvata sve završene porudžbine trenutnog korisnika.
     *
     * @return \Illuminate\Database\Eloquent\Collection Kolekcija porudžbina korisnika sa statusom 'completed'.
     */
    public function getUserOrders()
    {
        // Filtrira porudžbine korisnika prema njihovom ID-u i statusu 'completed'.
        return Order::where('user_id', Auth::id())
            ->where('status', Order::STATUS_COMPLETED)
            ->get();
    }

    /**
     * Dohvata detalje određene porudžbine za trenutnog korisnika.
     *
     * @param int $orderId ID porudžbine.
     * @return Order Detalji porudžbine.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Ako porudžbina nije pronađena.
     */
    public function getOrderDetails($orderId)
    {
        return Order::findOrFail($orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }

    /**
     * Završava trenutnu korpu korisnika, postavljajući status na 'completed'.
     *
     * @return Order|bool Završena porudžbina ili false ako korpa ne ispunjava uslove.
     */
    public function finalizeOrder() // mozda mi ova metoda nece trebati
    {
        // Pronalazi trenutnu korpu korisnika sa statusom 'pending'.
        $cart = Order::where('user_id', Auth::id())
            ->where('status', Order::STATUS_PENDING)
            ->first();

        // Proverava da li korpa postoji i da li ima proizvode.
        if (!$cart || $cart->products()->count() == 0) {
            return false; // Korpa nije validna za završavanje.
        }

        // Menja status korpe u 'completed' i čuva promene.
        $cart->status = Order::STATUS_COMPLETED;
        $cart->save();

        return $cart;
    }

    public function getOrders()
    {
        return Order::where('status', Order::STATUS_COMPLETED)->get();
    }
}
