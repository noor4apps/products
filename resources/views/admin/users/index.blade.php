@extends('admin.layouts.app')

    @section('content')
    <div class="container-fluid px-4">
        <h3 class="mt-4">{{ __('Users') }}</h3>
        <ol class="breadcrumb mb-4">
            <p>{{ __('List of all users') }}</p>
        </ol>
        @if (session('message'))
            <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add User</a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td class="text-center align-middle">
                            <div class="btn-group" role="group" aria-label="Second group">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="javascript:void(0)" onclick="if (confirm('Are you sure to delete this user?') ) { document.getElementById('user-delete-{{ $user->id }}').submit(); } else { return false; }"  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="post" id="user-delete-{{ $user->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
