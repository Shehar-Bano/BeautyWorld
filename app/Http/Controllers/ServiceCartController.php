<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Deal;
use App\Models\Orders;
use App\Models\OrderService;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;


class ServiceCartController extends Controller
{
    public function index()
    {


        $providers=User::where('designation','worker')->get();

        $services=Service::get();
        $deals=Deal::with('services')->get();
        return view('cart.cartSystem',compact('deals','providers','services'));
  }
  public function addToCart(Request $request)
  {

      $validated = $request->validate([
          'seatNumber' => 'required|string',
          'cartItems' => 'required|json'
      ]);

// dd($validated );
      $seatNumber = $validated['seatNumber'];
      $cartItems = json_decode($validated['cartItems'], true);
    //   dd($cartItems);

      DB::transaction(function() use ($seatNumber, $cartItems) {
        $cart = Cart::create([
            'seat_number' => $seatNumber,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $cartItemsData = array_map(function($item) use ($cart) {
            $data = [
                'cart_id' => $cart->id,
                'created_at' => now(),
                'updated_at' => now()
            ];

            if ($item['type'] === 'service') {
                $data['service_id'] = $item['id'];
                $data['deal_id'] = null; // Explicitly set deal_id to null
            } elseif ($item['type'] === 'deal') {
                $data['deal_id'] = $item['id'];
                $data['service_id'] = null; // Explicitly set service_id to null
            }

            return $data;
        }, $cartItems);

        // Check the data being inserted
        // dd($cartItemsData);

        try {
            CartItems::insert($cartItemsData);
        } catch (\Exception $e) {
            dd($e->getMessage()); // Catch any errors during insertion
        }
    });

      return redirect()->back()->with('success', 'Items set on hold successfully');
  }



    public function getSeatNumbers(){
        $seatNumbers = Cart::pluck('seat_number');
        return response()->json(['seatNumbers' => $seatNumbers]);
    }
    public function getCartItemsForSeat($seatNumber)
    {
        // Fetch the cart for the given seat number
        $cart = Cart::where('seat_number', $seatNumber)->first();

        // If the cart doesn't exist, return an empty response or handle accordingly
        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        // Fetch cart items with their related services and deals
        $cartItems = CartItems::with(['service', 'deal']) // Assuming you have a 'deal' relationship in CartItems
            ->where('cart_id', $cart->id)
            ->get();

        // Map the cart items to include service and deal details
        $response = $cartItems->map(function($cartItem) {
            $itemDetails = [];

            // Check if there's a service ID
            if ($cartItem->service_id) {
                $itemDetails = [
                    'id' => $cartItem->service_id,
                    'name' => $cartItem->service->name ?? 'Unnamed Service',
                    'price' => $cartItem->service->price ?? 0,

                    'type' => 'service',
                ];
            }

            // Check if there's a deal ID
            if ($cartItem->deal_id) {
                $itemDetails = [
                    'id' => $cartItem->deal_id,
                    'name' => $cartItem->deal->name ?? 'Unnamed Deal',
                    'price' => $cartItem->deal->dis_price ?? 0, // Assuming 'discounted_price' exists

                    'type' => 'deal',
                ];
            }

            return $itemDetails;
        });

        return response()->json($response);
    }

public function update(Request $request)
{

    $validated = $request->validate([
        'seatNumber' => 'required|string',
        'cartItems' => 'required|json'
    ]);
// dd($validated);
    $seatNumber = $validated['seatNumber'];
    $services = json_decode($validated['cartItems'], true);

    DB::transaction(function() use($seatNumber, $services) {
        $cart = Cart::where('seat_number', $seatNumber)->first();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart not found for the given seat number.'], 404);
        }

        CartItems::where('cart_id', $cart->id)->delete();

        $cartItems=array_map(function($serviceId) use($cart){
            return [
                'cart_id' => $cart->id,
                'service_id' => $serviceId,
                'created_at'=>now(),
                'updated_at'=>now()
                ];

        },$services);
        // dd($cartItems);
        CartItems::insert( $cartItems);
    });


    return redirect()->back()->with('success', 'Cart updated successfully!');
}


public function confirmOrder(Request $request)
{

    $validated = $request->validate([
        'provider_id' => 'required',
        'seatNumber' => 'nullable|string',
        'customerName' => 'required|string|max:50',
        'customerEmail' => 'required|email',
        'customerPhone' => 'required|regex:/^[0-9]{10,15}$/',
        'cartItems' => 'required|json',
    ]);

    $seatNumber = $validated['seatNumber'];
    $customerName = $validated['customerName'];
    $customerEmail = $validated['customerEmail'];
    $customerPhone = $validated['customerPhone'];
    $employee_id = $validated['provider_id'];
    $services = json_decode($validated['cartItems'], true);

    $totalPayment = collect($services)->sum('price');


    DB::beginTransaction();
    try {
        $order = Orders::create([
            'customer_name' => $customerName,
            'customer_phone' => $customerPhone,
            'customer_email' => $customerEmail,
            'total_payment' => $totalPayment,
            'date' => now(),
            'status' => 'unpaid',
        ]);

        $orderServices = collect($services)->map(function ($item) use ($order, $employee_id) {
            $data = [
                'order_id' => $order->id,
                'employee_id' => $employee_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if ($item['type'] === 'service') {
                $data['service_id'] = $item['id'];
                $data['deal_id'] = null;
            } elseif ($item['type'] === 'deal') {
                $data['deal_id'] = $item['id'];
                $data['service_id'] = null;
            }

            return $data;
        })->toArray();

        OrderService::insert($orderServices);
        DB::commit();

        if (!empty($seatNumber)) {
            $cart = Cart::where('seat_number', $seatNumber)->first();
            $cart->delete();



        CartItems::where('cart_id', $cart->id)->delete();
        }

        return redirect()->back()->with('success','Order confirmed successfully!');

    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->with('error', 'Failed to confirm order. Please try again.');
    }
}


}
