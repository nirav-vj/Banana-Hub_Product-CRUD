<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Userproduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;

class ProductController extends Controller
{
    public function homeindex()
    {
        $products = Product::all();
        return view('home', compact('products'));
    }

    public function create(ProductRequest $request)
    {

        $product = new Product;
        $product->first_name = $request['first_name'];
        $product->last_name = $request['last_name'];
        $product->email = $request['email'];
        $product->type_of_banana_Chips = $request['type_of_banana_Chips'];

        if ($request->has('file')) {
            $image = $request->file('file');
            $fileName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $fileName);
            $product->file = $fileName;
        }

        $product->mobile_number = $request['mobile_number'];
        $product->date = $request['date'];

        $product->pincode = $request['pincode'];
        $product->price = $request['price'];
        $product->address = $request['address'];
        $product->save();

        return redirect('home/index');

    }

    public function edit($id)
    {
        $product = Product::find($id);
        $product->accessories = explode(',', $product->accessories);

        return view('edit', ['data' => $product]);
    }

    public function product($id)
    {
        $product = Product::find($id);
        $number = User::where('id', Auth::id())->with('product')->orderby('name')->first();

        return view('product', ['data' => $product], compact('number'));
    }

     public function payment(Request $request)
    {
        $amount = $request->input('amount');
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $orderData = [
            'receipt' => 'order_' . rand(1000, 9999),
            'amount'  => $amount * 100,
            'currency' => 'INR',
            'payment_capture' => 1
        ];

        $order = $api->order->create($orderData);
        return view('payment', [
            'orderId' => $order["id"],
            'amount' => $amount * 100,
        ]);
    }


    public function storePayment(Request $request)
    {

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'razorpay_payment_id' => 'required'
        ]);

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        try {
            $payment = $api->payment->fetch($request->razorpay_payment_id);

            if ($payment->status == 'captured') {
                $product = Product::findOrFail($request->product_id);
                $user = Auth::user();

                Order::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'payment_id' => $request->razorpay_payment_id
                ]);

                return response()->json(['message' => 'Payment successful, Order placed']);
            } else {
                return response()->json(['message' => 'Payment failed or not captured'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Payment verification failed', 'error' => $e->getMessage()], 400);
        }
    }


    public function AddToCart($id)
    {
        $user = Auth::user();

        DB::table('user_product')->updateOrInsert(
            ['user_id' => $user->id, 'product_id' => $id],
            ['quantity' => DB::raw('quantity + 1'), 'updated_at' => now()]
        );

        return back();
    }

    public function cart()
    {

        $carts = User::where('id', Auth::id())->with('product')->orderby('name')->get();

        return view('add_to_cart', compact('carts'));
    }

    public function AddToCartDelete($id)
    {

        $userproduct = Userproduct::where('user_id', Auth::id())->where('product_id', $id)->first();

        $userproduct->delete();

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);
        $product->first_name = $request['first_name'];
        $product->last_name = $request['last_name'];
        $product->email = $request['email'];
        $product->type_of_banana_Chips = $request['type_of_banana_Chips'];

        if ($request->has('file')) {
            $image = $request->file('file');
            $fileName = time().'.'.$image->getClientOriginalExtension();
            // Store the file in the public/images directory
            $image->move(public_path('images'), $fileName);
            // Save the file name or path to the database
            $product->file = $fileName;
        }
        $product->mobile_number = $request['mobile_number'];
        $product->date = $request['date'];
        $product->pincode = $request['pincode'];
        $product->price = $request['price'];
        $product->address = $request['address'];
        $product->save();

        return redirect('home/index');
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $filePath = public_path('images').'/'.$product->file;

        if (File::exists($filePath)) {
            unlink($filePath);
        }

        $product->delete();

        return redirect()->back();
    }

    public function checkout()
    {
        // $user = User::where('id',Auth::user()->id)->first();
        $user = User::where('is_login', 1)->first();
        $user->is_login = 0;
        $user->save();

        return redirect('/ragister');
    }
}