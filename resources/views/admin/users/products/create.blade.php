@extends('admin.layouts.app')

    @section('content')
    <div class="container-fluid px-4">
        <h3 class="mt-4">{{ __('Assigning') }}</h3>
        <p>{{ __('Assign / Unassign Products to user:') }} {{ $user->full_name }}</p>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('User') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.products.index', $user) }}">{{ __('User Products') }}</a></li>
            <li class="breadcrumb-item active">Assigning</li>
        </ol>

        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg ">
                    <div class="card-body">
                        <form action="{{ route('admin.users.products.store', $user->id) }}" method="POST">
                            @csrf

                            <div class="form-check form-switch">
                                @foreach($products as $product)
                                    <input name="products[]" value="{{ $product->id }}" class="form-check-input" type="checkbox" id="Check-{{ $product->id }}" {{ is_array(old('$products', $user->products->pluck('id')->toArray())) && in_array($product->id, old('$products', $user->products->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Check-{{ $product->id }}"> {{ $product->name }}</label>
                                    <br />
                                @endforeach
                            </div>
                            @error('Products') <p class="fst-italic text-danger"> {{ $message }} </p> @enderror


                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Assigning</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
