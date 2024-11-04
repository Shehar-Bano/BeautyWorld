<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class ServiceCartController extends Controller
{
    public function index()
    {
        $services = Service::get();
        return view('cart.index', compact('services'));
    }
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'seatNumber' => 'required|string',
            'cartItems' => 'required|json'
        ]);

        $seatNumber = $validated['seatNumber'];
        $services = json_decode($validated['cartItems'], true);

        DB::transaction(function() use($seatNumber, $services){
           $cart= Cart::create([
                'seat_number' => $seatNumber,
            ]);
            $cartItems=array_map(function($serviceId) use($cart){
                return [
                    'cart_id' => $cart->id,
                    'service_id' => $serviceId,
                    ];

            },$services);
            CartItems::insert( $cartItems);
        });

        return redirect()->back()->with('items set on hold successfully');

    }

    public function getSeatNumbers(){
        $seatNumbers = Cart::pluck('seat_number');
        return response()->json(['seatNumbers' => $seatNumbers]);
    }
public function getCartItemsForSeat($seatNumber)
{
    $cart = Cart::where('seat_number', $seatNumber)->first();
    $cartItems=CartItems::with('service')->where('cart_id',$cart->id)->get();
    $response = $cartItems->map(function($cartItem) {
        return [
            'id' => $cartItem->id,
            'name' => $cartItem->service->name ?? 'Unnamed Service',
            'price' => $cartItem->service->price ?? 0,
            'tax' => isset($cartItem->service->price) ? round($cartItem->service->price * 0.05) : 0,
        ];
    });

    return response()->json(['cartItems' => $response]);
}

public function update(Request $request)
{
    try {
        $validated = $request->validate([
            'seatNumber' => 'required|string',
            'cartItems' => 'required|array'  // Expect an array of IDs
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $e->validator->errors()
        ], 422);
    }

    $seatNumber = $validated['seatNumber'];
    $serviceIds = $validated['cartItems'];  // This is now an array of IDs

    DB::transaction(function() use($seatNumber, $serviceIds) {
        $cart = Cart::where('seat_number', $seatNumber)->first();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart not found for the given seat number.'], 404);
        }

        // Clear existing cart items
        CartItems::where('cart_id', $cart->id)->delete();

        // Prepare new cart items with service IDs only
        $cartItems = array_map(function($serviceId) use($cart) {
            return [
                'cart_id' => $cart->id,
                'service_id' => $serviceId,
            ];
        }, $serviceIds);

        // Insert new cart items
        CartItems::insert($cartItems);

        return response()->json(['success' => true, 'message' => 'Cart updated successfully!']);
    });
}


}
