<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::isUser()->select('id', 'first_name', 'last_name', 'email', 'phone_number')->latest()->paginate(5);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'phone_number' => ['required', 'unique:users'],
            'password' => ['required', 'min:8'],
        ]);

        $request->merge([
            'password' => bcrypt($request['password'])
        ]);

        $params = $request->except('_token');

        $user = User::create($params);


        if (!$user) {
            return redirect()->back()->with([
                'message' => 'Error occurred while creating user.',
                'alert-type' => 'error'
            ]);
        }
        return redirect()->route('admin.users.index')->with([
            'message' => 'User added successfully',
            'alert-type' => 'success'
        ]);
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'. $user->id],
            'phone_number' => ['required', 'unique:users,phone_number,'. $user->id],
            'password' => ['nullable', 'min:8'],
        ]);

        $params = $request->except(['_token', 'password']);

        // ignore password fields if blank
        if($request->has('password') and isset($request->password))
        {
            $params['password'] = bcrypt($request->password);
        }

        $user = $user->update($params);

        if (!$user) {
            return redirect()->back()->with([
                'message' => 'Error occurred while updated user.',
                'alert-type' => 'error'
            ]);
        }
        return redirect()->route('admin.users.index')->with([
            'message' => 'User updated successfully',
            'alert-type' => 'success'
        ]);    }

    public function destroy(User $user)
    {
        $user = $user->delete();

        if (!$user) {
            return redirect()->back()->with([
                'message' => 'Error occurred while deleting user.',
                'alert-type' => 'error'
            ]);
        }
        return redirect()->route('admin.users.index')->with([
            'message' => 'User deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}
