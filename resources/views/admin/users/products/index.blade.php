@extends('admin.layouts.app')

    @section('content')
    <div class="container-fluid px-4">
        <h3 class="mt-4">{{ __('User Products') }}</h3>
        <p>{{ __('List of all products user:') }} {{ $user->full_name }}</p>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a></li>
            <li class="breadcrumb-item active">User Products</li>
        </ol>
        @if (session('message'))
            <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <a href="{{ route('admin.users.products.create', $user) }}" class="btn btn-primary">Assign / Unassign Products</a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th style="width:20%;">Image</th>
                        <th>description</th>
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
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
