@extends('admin.layouts.app')

    @section('content')
    <div class="container-fluid px-4">
        <h3 class="mt-4">{{ __('Products') }}</h3>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">{{ __('Products') }}</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>

        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg ">
                    <div class="card-body">
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-floating mb-3">
                                <input name="name" class="form-control" id="name" type="text" value="{{ old('name') }}" placeholder="Name" />
                                <label for="name">Name</label>
                            </div>
                            @error('name') <p class="fst-italic text-danger"> {{ $message }} </p> @enderror

                            <div class="form-floating mb-3">
                                <input name="description" class="form-control" id="description" type="text" value="{{ old('description') }}" placeholder="Description" />
                                <label for="description">Description</label>
                            </div>
                            @error('description') <p class="fst-italic text-danger"> {{ $message }} </p> @enderror

                            <div class="form-floating mb-3">
                                <input name="image" class="form-control" type="file" value="{{ old('image') }}" />
                            </div>
                            @error('image')<p class="fst-italic text-danger"> {{ $message }} </p>@enderror

                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
