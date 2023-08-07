<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    //
    public function verify(Request $request, $id) {
        
        $user = User::findOrFail($id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        if ($user->hasVerifiedEmail()) {
            return redirect("/verify?message=Email+already+verified.");
        }

        if (!$user) {
            return redirect('/verify?message=Email+not+registered.');
        }

        return redirect('/verify?message=Email+verified.');
    }
}
