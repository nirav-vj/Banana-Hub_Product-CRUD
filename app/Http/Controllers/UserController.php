<?php

namespace App\Http\Controllers;

use App\Models\Bananahub;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function home()
    {
        $products = Product::all();

        return view('home', compact('products'));
    }

    public function user()
    {
        $users = Auth::user();

        return view('user', compact('users'));
    }

    public function password(Request $request)
    {
        return view('password');

    }

    public function password_update(Request $request)
    {

        $request->validate([
            'password' => 'required',
            'new_password' => 'required|min:6',
            'password_confirmation' => 'required|min:6|same:new_password',
        ]);

        $userId = Auth::user()->id;
        $user = User::find($userId);

        if (! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Current password dose not match.',
            ]);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();

        return 'Password Updated successfully!';

    }

    public function user_picture(Request $request)
    {
        $request->validate([
            'file' => 'required|image',
        ]);

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $fileName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $fileName);
            $user = auth()->user();
            $user->file = $fileName;
            $user->save();

            return redirect()->back();
        }

        return redirect()->back()->with('error', 'No file selected.');
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if ($search != '') {
            $bananahubs = Product::where('type_of_banana_Chips', 'LIKE', "%$search%")
                ->orWhere('price', 'LIKE', "%$search%")
                ->get();
        } else {
            $bananahubs = Product::all();
        }

        return view('home', compact('bananahubs'));
    }

    public function create()
    {
        return view('/create');
    }
}