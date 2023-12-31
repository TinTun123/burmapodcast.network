<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Audience;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use App\Rules\AtLeastOneRequired;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
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
            Log::info('user', [
                $user->id
            ]);

            return response()->json([
                'token' => $token,
                'user_level' => $user->user_level,
                'user_id' => $user->id,
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

        if ($request->input('level') === '3') {
            
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6',
                'password_confirmation' => 'required| min:8',
                'profile_img' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'level' => 'required|integer|in:1,2,3'
            ]);

        } else {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'profile_img' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'level' => 'required|integer|in:1,2,3'
            ]);
        }

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $currentUser = Auth::user();

        $currentUser = User::findOrFail($currentUser->id);
      ;
        if ($currentUser->user_level !== 2 && $currentUser->user_level !== 3) {
            return response()->json(['error' => 'only admin and host can add new user.'], 301);
        }
        $password = Hash::make('Q#8Zv$4sW@Kt$5Lx&1YQ#8Zv$4sW@Kt$5Lx&1Y');
        $email = $request->input('name') . Carbon::now()->timestamp . '@gmail.com';

        if ($request->input('level') === '3') {
            $password = $request->input('password');
            $email = $request->input('email');
        }

        $img_url = null;
        if ($request->file('profile_img')) {
            $img_url = $this->storeImage($request->file('profile_img'), $request->input('name'), 'profile');
        }

        $admin = User::create([
            'name' => $request->input('name'),
            'email' => $email,
            'password' => $password,
            'user_level' => (int)$request->input('level'),
            'profile_url' => $img_url
        ]);

        if ($admin->user_level === 3) {
            $admin->sendEmailVerificationNotification();
        }

        if ($admin->user_level === 3) {
            $role = 'admin';
        } else if ($admin->user_level === 2) {
            $role = 'host';
        } else if ($admin->user_level === 1) {
            $role = 'co-host';
        }

        ActivityLog::create([
            'name' => $currentUser->name,
            'log_details' => "Add new $role '$admin->name'",
            'log_type' => 'create'
        ]);

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
            'profile_img' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            new AtLeastOneRequired(),
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->error()], 422);
        }

        $currentUser = Auth::user();

        $currentUser = User::findOrFail($currentUser->id);

        if ($request->input('level') > 1) {
            if ($currentUser->user_level !== 2 && $currentUser->user_level !== 3) {
                return response()->json(['error' => 'only Admin/host can assign user privilege.'], 302);
            }
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

        if ($request->input('level')) {
            $user->user_level = $request->input('level');
        }

        if ($request->file('profile_img')) {
            $user->profile_url = $this->storeImage($request->file('profile_img'), $user->name, 'profile');
        }

        $user->save();

        ActivityLog::create([
            'name' => $currentUser->name,
            'log_details' => "Edited $user->name info",
            'log_type' => 'edit'
        ]);

        return response()->json(['success' => $user->name . ' user info was updated.', 'user' => $user], 200);
    }

    public function delete(Request $request, User $user) {

        $currentUserid = Auth::id();

        $currentUser = User::findOrFail($currentUserid);

        if ($currentUser->user_level !== 2 && $currentUser->user_level !== 3) {
            return response()->json(['error' => 'only admin/host can delete users.', 302]);
        }

        $user->delete();

        ActivityLog::create([
            'name' => $currentUser->name,
            'log_details' => "Delete $user->name",
            'log_type' => 'delete'
        ]);

        return response()->json(['success' => $user->name . ' was deleted.', 'user' => $user], 200);
    }

    public function logout(Request $request) {
        
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json(['success' => 'Logout successful'], 200);
    }

    public function getLog(Request $request) {
        $logs = ActivityLog::orderBy('created_at', 'desc')->paginate(5);

        Log::info('log', [
            $logs
        ]);
    

        return response()->json(['log' => $logs], 200);
    }

    private function storeImage($file, $hostName, $type) {
        $hostName = str_replace(' ', '', $hostName);

        $directory = 'public/' . $type . '/' . $hostName;

        if (Storage::exists($directory)) {
            Storage::deleteDirectory($directory);
        }

        $filename = $hostName . '-' . time() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs('public/' . $type . '/' . $hostName, $filename);

        $storagePath = storage_path('app/' . $path);
        
        chmod(dirname($storagePath), 0755);

        $publicURL = asset('storage/' . $type . '/' . $hostName . '/' . $filename);

        return $publicURL;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
