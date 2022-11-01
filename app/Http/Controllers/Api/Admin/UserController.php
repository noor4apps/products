<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::isUser()->select('id', 'first_name', 'last_name', 'email', 'phone_number')->latest()->paginate(5);

        if ($users) {
            $data = UserResource::collection($users)->response()->getData(true);
            return response()->json(['data' => $data, 'error' => 0, 'message' => ''], 200);
        }

        return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'phone_number' => ['required', 'numeric', 'unique:users'],
            'password' => ['required', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => null, 'error' => 1, 'message' => $validator->errors()->first()], 201);
        }

        $params = $request->except('_token');

        $user = User::create($params);

        if ($user) {
            return response()->json(['data' => null, 'error' => 0, 'message' => 'User added successfully.'], 200);
        }

        return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
    }

    public function show($user)
    {
        $user = User::isUser()->whereId($user)->select('id', 'first_name', 'last_name', 'email', 'phone_number')->first();

        if ($user) {
            $data = new UserResource($user);
            return response()->json(['data' => $data, 'error' => 0, 'message' => ''], 200);
        }

        return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
    }

    public function update(Request $request, $user)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'. $user],
            'phone_number' => ['required', 'numeric', 'unique:users,phone_number,'. $user],
            'password' => ['nullable', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => null, 'error' => 1, 'message' => $validator->errors()->first()], 201);
        }

        $params = $request->except(['_token', 'password']);

        // ignore password fields if blank
        if($request->has('password'))
        {
            $params['password'] = bcrypt($request->password);
        }

        $user = User::isUser()->whereId($user)->select('id', 'first_name', 'last_name', 'email', 'phone_number')->first();

        if (!$user) {
            return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
        }

        if ($user->update($params)) {
            return response()->json(['data' => null, 'error' => 0, 'message' => 'User updated successfully'], 200);
        }

        return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
    }

    public function destroy($user)
    {
        $user = User::isUser()->whereId($user)->select('id', 'email')->first();

        if (!$user) {
            return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
        }

        if ($user->delete()) {
            return response()->json(['data' => null, 'error' => 0, 'message' => 'User deleted successfully.'], 200);
        }

        return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
    }
}
