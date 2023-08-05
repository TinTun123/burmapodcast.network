<?php

namespace App\Http\Controllers;

use App\Models\Audience;
use App\Models\User;
use App\Rules\AtLeastOneRequired;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    use HasApiTokens;
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        if(Auth::attempt([ 'email' => $request->input('email'),'password' => $request->input('password')])) {
            
            $user = User::where('email', '=', $request->input('email'))->firstOrFail();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user_level' => $user->user_level,
                'success' => 'Login Successful.'
            ], 200);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function signin(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required| min:8',
            'level' => 'required|integer|in:1,2,3'
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $currentUser = Auth::user();

        $currentUser = User::findOrFail($currentUser->id);

        if ($currentUser->user_level !== 2) {
            return response()->json(['error' => 'only host can add new user.'], 304);
        }

        $admin = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'user_level' => $request->input('level')
        ]);

        return response()->json([
            'success' => 'User register successful',
            'user' => $admin
        ], 200);
    }

    public function addAudience(Request $request) {
        $validator = Validator::make($request->all(), [
            'audienceName' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $audience =  Audience::create([
            'name' => $request->input('audienceName')
        ]);

        return response()->json(['success' => ' ', 'audience' => $audience], 200);
    }

    /**
     * Display the specified resource.
     */
    public function getUsers(Request $request)
    {
        //
        $users = User::get()->toArray();
        return response()->json( [ 
            'users' => $users,
            'success' => ''
    ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //

        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string'],
            'password' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'level' => 'integer|in:1,2,3',
            new AtLeastOneRequired(),
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->error()], 422);
        }

        $currentUser = Auth::user();

        $currentUser = User::findOrFail($currentUser->id);

        if ($currentUser->user_level !== 2) {
            return response()->json(['error' => 'only host can update user info.'], 304);
        }

        if ($request->input('name')) {
            $user->name = $request->input('name');
        }

        if ($request->input('email')) {
            $user->email = $request->input('email');
        }

        if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
        }


        $user->save();

        return response()->json(['success' => $user->name . ' user info was updated.', 'user' => $user], 200);
    }

    public function delete(Request $request, User $user) {

        $currentUserid = Auth::id();

        $currentUser = User::findOrFail($currentUserid);

        if ($currentUser->user_level !== 2) {
            return response()->json(['error' => 'only host can delete users.', 304]);
        }

        $user->delete();

        return response()->json(['success' => $user->name . ' was deleted.', 'user' => $user], 200);
    }

    public function logout(Request $request) {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json(['success' => 'Logout successful'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
