<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class UserProductController extends Controller
{
    public function index(User $user)
    {
        $products = $user->products()->paginate(5);

        return view('admin.users.products.index', compact('user', 'products'));
    }

    public function create(User $user)
    {
        $user->load('products');
        $products = Product::latest()->get();

        return view('admin.users.products.create', compact('user', 'products'));
    }

    public function store(Request $request, User $user)
    {
        $this->validate($request, [
            'products' => ['required', 'array'],
            'products.*' => ['exists:products,id'],
        ]);

        $res = $user->products()->sync($request->products);

        if (!$res) {
            return redirect()->back()->with([
                'message' => 'Error occurred while assigned products to user.',
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('admin.users.products.index', $user->id)->with([
            'message' => 'Products assigning successfully',
            'alert-type' => 'success'
        ]);
    }
}
