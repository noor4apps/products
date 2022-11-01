<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required_without:phone_number', 'email'],
            'phone_number' => ['required_without:email', 'numeric'],
            'password' => ['required', 'min:8']
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => null, 'error' => 1, 'message' => $validator->errors()->first()], 201);
        }

        $credentialsByEmail = Auth::attempt(['email' => request('email'), 'password' => request('password')]);
        $credentialsByPhoneNumber = Auth::attempt(['phone_number' => request('phone_number'), 'password' => request('password')]);

        if ($credentialsByPhoneNumber || $credentialsByEmail) {

            $user = auth()->user();

            $data['user'] = new UserResource($user);
            $data['token'] = $user->createToken('api-token')->plainTextToken;

            return response()->json(['data' => $data, 'error' => 0, 'message' => 'You are logged in successfully'], 200);
        }

        return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'phone_number' => ['required', 'numeric', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => null, 'error' => 1, 'message' => $validator->errors()->first()], 200);
        }

        $user = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
            'is_admin' => 0,
            'password' => Hash::make($request['password']),
        ]);

        if ($user) {
            $data['user'] = new UserResource($user);
            $data['token'] = $user->createToken('api-token')->plainTextToken;

            return response()->json(['data' => $data, 'error' => 0, 'message' => 'Successfully Registered'], 200);
        }

        return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
    }

    public function userInformation()
    {
        $user = auth()->user();

        return response()->json(['data' => new UserResource($user), 'error' => 0, 'message' => ''], 200);
    }

    public function updateUserInformation(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'phone_number' => ['required', 'numeric', 'unique:users,phone_number,' . $user->id],
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => null, 'error' => 1, 'message' => $validator->errors()->first()], 200);
        }

        $params = $request->except('_token');

        if (!$user) {
            return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
        }

        if ($user->update($params)) {
            return response()->json(['data' => null, 'error' => 0, 'message' => 'User updated successfully.'], 200);
        }

        return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'min:8'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => null, 'error' => 1, 'message' => $validator->errors()->first()], 200);
        }

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['data' => null, 'error' => 1, 'message' => 'The old Password Doesn\'t match!'], 201);
        }
        $update = $user->update([
            'password' => bcrypt($request->password),
        ]);

        if ($update) {
            return response()->json(['data' => null, 'error' => 0, 'message' => 'Password updated successfully'], 200);
        }

        return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
    }

    public function logout()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
        }

        if ($user->tokens()->delete()) {
            return response()->json(['data' => null, 'error' => 0, 'message' => 'logged out'], 200);
        }

        return response()->json(['data' => null, 'error' => 1, 'message' => 'Something went wrong!'], 201);
    }

}
