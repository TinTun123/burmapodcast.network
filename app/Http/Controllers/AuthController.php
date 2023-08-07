<?php

namespace App\Http\Controllers;

use App\Models\Audience;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use App\Rules\AtLeastOneRequired;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
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


            if (!$user->hasVerifiedEmail()) {
                return response()->json(['error' => 'Email is not verified yet'], 403);
            }
            
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

    public function resend(Request $request) {

        $validator = Validator::make($request->all(), [

            'email' => 'required|email'

        ]);

        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()], 422);

        }

        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => $email . ' is not registered.'], 404);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(['success' => 'Verification email have been sent to ' . $email . '. Please verify and login again.']);
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

        $admin->sendEmailVerificationNotification();

        return response()->json([
            'success' => 'User register successful',
            'user' => $admin
        ], 200);
    }

    public function sendResetPwdEmail(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->input('email'))->first();

        if(!$user) {
            return response()->json(['error' => 'Email not register.'], 404);
        }

        $token = Password::createToken($user);

        $user->notify(new ResetPasswordNotification($token));

        return response()->json(['success' => 'Password reset email sent']);
        
    }

    public function reset(Request $request) {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $resetStatus = Password::reset(
            $request->only('email', 'token', 'password', 'password_confirmation'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($resetStatus === Password::PASSWORD_RESET) {
            return response()->json(['success' => 'Password reset for ' . $request->input('email')], 200);
        } else {
            return response()->json(['error' => 'Password reset fail. Contact Sayar Tin'], 422);
        }
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
