@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Your Products') }}</div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th style="width:20%;">Image</th>
                            <th>description</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $product)
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
                        @empty
                            <td colspan="3" class="text-center"> No Products! </td>
                        @endforelse
                        </tbody>
                    </table>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
