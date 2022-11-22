@extends('admin.layouts.app')

    @section('content')
    <div class="container-fluid px-4">
        <h3 class="mt-4">{{ __('Users') }}</h3>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a></li>
            <li class="breadcrumb-item active">Update: {{ $user->full_name }}</li>
        </ol>

        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg ">
                    <div class="card-body">
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="form-floating mb-3">
                                <input name="first_name" class="form-control" id="first_name" type="text" value="{{ old('first_name', $user->first_name) }}" placeholder="First Name" />
                                <label for="first_name">First Name</label>
                            </div>
                            @error('first_name') <p class="fst-italic text-danger"> {{ $message }} </p> @enderror

                            <div class="form-floating mb-3">
                                <input name="last_name" class="form-control" id="last_name" type="text" value="{{ old('last_name', $user->last_name) }}" placeholder="Last Name" />
                                <label for="last_name">Last Name</label>
                            </div>
                            @error('last_name') <p class="fst-italic text-danger"> {{ $message }} </p> @enderror

                            <div class="form-floating mb-3">
                                <input name="email" class="form-control" id="email" type="email" value="{{ old('email', $user->email) }}" placeholder="Email" />
                                <label for="email">Email</label>
                            </div>
                            @error('email') <p class="fst-italic text-danger"> {{ $message }} </p> @enderror

                            <div class="form-floating mb-3">
                                <input name="phone_number" class="form-control" id="phone_number" type="text" value="{{ old('phone_number', $user->phone_number) }}" placeholder="Phone Number" />
                                <label for="phone_number">Phone Number</label>
                            </div>
                            @error('phone_number') <p class="fst-italic text-danger"> {{ $message }} </p> @enderror

                            <div class="form-floating mb-3">
                                <input name="password" class="form-control" id="password" type="password" value="{{ old('password') }}" placeholder="Password" />
                                <label for="password">Leave Password blank if you do not want to change it</label>
                            </div>
                            @error('password') <p class="fst-italic text-danger"> {{ $message }} </p> @enderror

                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
