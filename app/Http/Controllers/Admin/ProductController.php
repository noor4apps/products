<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255', 'unique:products'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,bmp,svg,webp'],
            'description' => ['required', 'string'],
        ]);

        $params = $request->except('_token', 'image');

        if ($request->has('image') && ($request->file('image') instanceof UploadedFile)) {
            $image = $this->uploadOne($request->file('image'), 'products');
            $params['image'] = $image;
        }

        $product = Product::create($params);

        if (!$product) {
            return redirect()->back()->with([
                'message' => 'Error occurred while creating product.',
                'alert-type' => 'error'
            ]);
        }
        return redirect()->route('admin.products.index')->with([
            'message' => 'Product added successfully',
            'alert-type' => 'success'
        ]);
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255', 'unique:products,name,' . $product->id],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,bmp,svg,webp'],
            'description' => ['required', 'string'],
        ]);

        $params = $request->except(['_token', 'image']);

        if ($request->has('image') && ($request->file('image') instanceof UploadedFile)) {
            if ($product->image != null) {
                $this->deleteOne($product->image);
            }
            $image = $this->uploadOne($request->file('image'), 'products');
            $params['image'] = $image;
        }

        $product = $product->update($params);

        if (!$product) {
            return redirect()->back()->with([
                'message' => 'Error occurred while updated product.',
                'alert-type' => 'error'
            ]);
        }
        return redirect()->route('admin.products.index')->with([
            'message' => 'Product updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(Product $product)
    {
        if ($product->image != null) {
            $this->deleteOne($product->image);
        }

        $product = $product->delete();

        if (!$product) {
            return redirect()->back()->with([
                'message' => 'Error occurred while deleting product.',
                'alert-type' => 'error'
            ]);
        }
        return redirect()->route('admin.products.index')->with([
            'message' => 'Product deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}
