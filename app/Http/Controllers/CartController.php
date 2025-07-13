<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\ICartService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(ICartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = Order::where('user_id', Auth::id())
            ->where('status', 'pending') // Loading only pending orders
            ->with('products') // Correctly eager load the 'products' relationship (plural)
            ->get();

        $cartTotal = $cartItems->sum(function ($item) {
            return $item->products->sum(function ($product) {
                return $product->pivot->quantity * $product->price;
            });
        });

        return view('cart.index', compact('cartItems', 'cartTotal'));
    }

    public function show()
    {
        $cart = $this->cartService->getCart();

        return view('cart.show', compact('cart'));
    }

    public function add(Request $request, $product)
    {
        try {
            $this->cartService->addToCart($product, $request->input('quantity', 1));
            return redirect()->back()->with('success', 'Product added to cart successfully!.');
        }
        catch (Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function remove($productId)
    {
        $success = $this->cartService->removeFromCart($productId);

        if ($success) {
            return redirect()->back()->with('success', 'Product is removed from cart successfully!.');
        }

        return redirect()->back()->with('error', "Product isn't found in the cart.");
    }

    public function completeCart()
    {
        try {
            $cart = $this->cartService->completeCart();

            if (!$cart) {
                return redirect()->back()->with('error', 'Cart is empty.');
            }
//            dd($cart);
            return redirect()->route('cart.index')->with('success', 'The purchase was successfully completed.');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

}
