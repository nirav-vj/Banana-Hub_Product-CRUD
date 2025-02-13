<?php

namespace App\Http\Controllers;

use App\Http\Requests\BananahubRequest;
use App\Models\Bananahub;
use App\Models\User;
use App\Models\Userproduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Razorpay\Api\Api;

class BananahubController extends Controller
{
    public function homeindex()
    {
        $bananahubs = Bananahub::all();

        return view('home', compact('bananahubs'));
    }

    public function create(BananahubRequest $request)
    {

        $bananahub = new Bananahub;
        $bananahub->first_name = $request['first_name'];
        $bananahub->last_name = $request['last_name'];
        $bananahub->email = $request['email'];
        $bananahub->type_of_banana_Chips = $request['type_of_banana_Chips'];

        if ($request->has('file')) {
            $image = $request->file('file');
            $fileName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $fileName);
            $bananahub->file = $fileName;
        }

        $bananahub->mobile_number = $request['mobile_number'];
        $bananahub->date = $request['date'];

        $bananahub->pincode = $request['pincode'];
        $bananahub->price = $request['price'];
        $bananahub->address = $request['address'];
        $bananahub->save();

        return redirect('home/index');

    }

    public function edit($id)
    {
        $bananahub = Bananahub::find($id);
        $bananahub->accessories = explode(',', $bananahub->accessories);

        return view('edit', ['data' => $bananahub]);
    }

    public function product($id)
    {
        $bananahub = Bananahub::find($id);
        $number = User::where('id', Auth::id())->with('product')->orderby('name')->first();

        return view('product', ['data' => $bananahub], compact('number'));
    }

    public function payment(Request $request)
    {
        $amount = Request::input('amount');
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
            'amount' => $amount * 100
        ]);
    }

    public function AddToCart($id)
    {
        $user = Auth::user();
        $product = Bananahub::find($id);
        $product->users()->attach($user->id);

        return redirect()->back();
    }

    public function cart()
    {

        $carts = User::where('id', Auth::id())->with('product')->orderby('name')->get();

        return view('add_to_cart', compact('carts'));
    }

    public function AddToCartDelete($id)
    {

        $userproduct = Userproduct::where('user_id', Auth::id())->where('bananahub_id', $id)->first();

        $userproduct->delete();

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BananahubRequest $request, $id)
    {
        $bananahub = Bananahub::find($id);
        $bananahub->first_name = $request['first_name'];
        $bananahub->last_name = $request['last_name'];
        $bananahub->email = $request['email'];
        $bananahub->type_of_banana_Chips = $request['type_of_banana_Chips'];

        if ($request->has('file')) {
            $image = $request->file('file');
            $fileName = time().'.'.$image->getClientOriginalExtension();
            // Store the file in the public/images directory
            $image->move(public_path('images'), $fileName);
            // Save the file name or path to the database
            $bananahub->file = $fileName;
        }
        $bananahub->mobile_number = $request['mobile_number'];
        $bananahub->date = $request['date'];
        $bananahub->pincode = $request['pincode'];
        $bananahub->price = $request['price'];
        $bananahub->address = $request['address'];
        $bananahub->save();

        return redirect('home/index');
    }

    public function delete($id)
    {
        $bananahub = Bananahub::find($id);
        $filePath = public_path('images').'/'.$bananahub->file;

        if (File::exists($filePath)) {
            unlink($filePath);
        }

        $bananahub->delete();

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