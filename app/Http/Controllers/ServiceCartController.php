<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Orders;
use App\Models\OrderService;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class ServiceCartController extends Controller
{
    public function index()
    {

        $providers=User::where('designation','worker')->get();
       
        $services=Service::get();
        return view('cart.cartSystem',compact('providers','services'));
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
                    'created_at'=>now(),
                    'updated_at'=>now()


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
            'id' => $cartItem->service_id,
            'name' => $cartItem->service->name ?? 'Unnamed Service',
            'price' => $cartItem->service->price ?? 0,
            'tax' => isset($cartItem->service->price) ? round($cartItem->service->price * 0.05) : 0,
        ];
    });

    return response()->json(['cartItems' => $response]);
}

public function update(Request $request)
{
   
    $validated = $request->validate([
        'seatNumber' => 'required|string',
        'cartItems' => 'required|json'
    ]);

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
        'provider_id'=>'required',
        'seatNumber' => 'nullable|string',
        'customerName' => 'required|string|max:50',
        'customerEmail' => 'required|email',
        'customerPhone' => 'required|regex:/^[0-9]{10,15}$/',
        'cartItems' => 'required|json',
    ]);

    // Parse validated data
    $seatNumber = $validated['seatNumber'];
    $customerName = $validated['customerName'];
    $customerEmail = $validated['customerEmail'];
    $customerPhone = $validated['customerPhone'];
    $employee_id=$validated['provider_id'];
    $services = json_decode($validated['cartItems'], true);

    // Calculate total payment using collection methods
    $totalPayment = collect($services)->sum('price');

    // Use a transaction to ensure data consistency
    DB::beginTransaction();
    try {
        // Create Order
        $order = Orders::create([
            'customer_name' => $customerName,
            'customer_phone' => $customerPhone,
            'customer_email' => $customerEmail,
            'total_payment' => $totalPayment,
            'date' => now(),
            'status' => 'unpaid',
        ]);

        // Prepare OrderService data using collection methods
        $orderServices = collect($services)->map(function ($service) use ($order, $employee_id) {
            return [
                'order_id' => $order->id,
                'service_id' => $service['id'],
                'employee_id' => $employee_id, // Assuming employee_id is predetermined or fetched separately
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        // Insert all OrderService records at once
        OrderService::insert($orderServices);

        // Commit the transaction
        DB::commit();
        if (!empty($seatNumber)) {
            $cart = Cart::where('seat_number', $seatNumber)->first();
            $cart->delete();
            

        
        CartItems::where('cart_id', $cart->id)->delete();
        }

        return redirect()->back()->with('success','Order confirmed successfully!');
        
    } catch (\Exception $e) {
        // Rollback transaction on error
        DB::rollback();
        return redirect()->back()->with( 'error','Failed to confirm order. Please try again.');
    }
}


}
