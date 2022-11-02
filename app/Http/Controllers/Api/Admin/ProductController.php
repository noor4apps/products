<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use UploadAble;

    public function index()
    {
        $products = Product::select('id', 'name', 'image', 'description')->latest()->paginate(5);

        if ($products) {
            $data = ProductResource::collection($products)->response()->getData(true);
            return response()->json(['data' => $data, 'error' => 0, 'message' => ''], 200);
        }

        return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:products'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,bmp,svg,webp'],
            'description' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => null, 'error' => 1, 'message' => $validator->errors()->first()], 201);
        }

        $params = $request->except('_token', 'image');

        if ($request->has('image') && ($request->file('image') instanceof UploadedFile)) {
            $image = $this->uploadOne($request->file('image'), 'products');
            $params['image'] = $image;
        }

        $product = Product::create($params);

        if ($product) {
            return response()->json(['data' => null, 'error' => 0, 'message' => 'Product added successfully.'], 200);
        }

        return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
    }

    public function show($product)
    {
        $product = Product::whereId($product)->select('id', 'name', 'image', 'description')->first();

        if ($product) {
            $data = new ProductResource($product);
            return response()->json(['data' => $data, 'error' => 0, 'message' => ''], 200);
        }

        return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
    }

    public function update(Request $request, $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:products,name,' . $product],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,bmp,svg,webp'],
            'description' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => null, 'error' => 1, 'message' => $validator->errors()->first()], 201);
        }

        $params = $request->except(['_token', 'image']);

        $product = Product::whereId($product)->select('id', 'image')->first();

        if (!$product) {
            return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
        }

        if ($request->has('image') && ($request->file('image') instanceof UploadedFile)) {
            if ($product->image != null) {
                $this->deleteOne($product->image);
            }
            $image = $this->uploadOne($request->file('image'), 'products');
            $params['image'] = $image;
        }

        if ($product->update($params)) {
            return response()->json(['data' => null, 'error' => 0, 'message' => 'Product updated successfully'], 200);
        }

        return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
    }

    public function destroy($product)
    {
        $product = Product::whereId($product)->select('id', 'image')->first();

        if (!$product) {
            return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
        }

        if ($product->image != null) {
            $this->deleteOne($product->image);
        }

        if ($product->delete()) {
            return response()->json(['data' => null, 'error' => 0, 'message' => 'Product deleted successfully.'], 200);
        }

        return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
    }
}
