@extends('admin.layouts.app')

    @section('content')
    <div class="container-fluid px-4">
        <h3 class="mt-4">{{ __('Products') }}</h3>
        <ol class="breadcrumb mb-4">
            <p>{{ __('List of all products') }}</p>
        </ol>
        @if (session('message'))
            <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th style="width:20%;">Image</th>
                        <th>description</th>
                        <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td style="padding: 0; width:20%;">
                            @if($product->image)
                                <img src="{{ $product->img_full_path }}" style="width: 100%; height: auto;">
                            @else
                                <img src="https://via.placeholder.com/120x80" style="width: 100%; height: auto;">
                            @endif
                        </td>
                        <td>{{ $product->description }}</td>
                        <td class="text-center align-middle">
                            <div class="btn-group" role="group" aria-label="Second group">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="javascript:void(0)" onclick="if (confirm('Are you sure to delete this product?') ) { document.getElementById('product-delete-{{ $product->id }}').submit(); } else { return false; }"  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="post" id="product-delete-{{ $product->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
