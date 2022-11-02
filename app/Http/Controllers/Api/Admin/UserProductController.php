<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserProductController extends Controller
{
    public function index($user)
    {
        $user = User::whereId($user)->first();

        if (!$user) {
            return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
        }

        $products = $user->products()->paginate(5);

        if ($products) {
            $data = ProductResource::collection($products)->response()->getData(true);
            return response()->json(['data' => $data, 'error' => 0, 'message' => ''], 200);
        }

        return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
    }

    public function create($user)
    {
        $user = User::whereId($user)->first();
        $products = Product::latest()->get();

        if ($user and $products) {
            $data['user'] = new UserResource($user);
            $data['products'] = ProductResource::collection($products);
            return response()->json(['data' => $data, 'error' => 0, 'message' => ''], 200);
        }

        return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
    }

    public function store(Request $request, $user)
    {
        $validator = Validator::make($request->all(), [
            'products' => ['required', 'array'],
            'products.*' => ['exists:products,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => null, 'error' => 1, 'message' => $validator->errors()->first()], 201);
        }

        $user = User::whereId($user)->first();

        if (!$user) {
            return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
        }

        $res = $user->products()->sync($request->products);

        if ($res) {
            return response()->json(['data' => null, 'error' => 0, 'message' => 'Product assigned successfully.'], 200);
        }

        return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
    }
}
