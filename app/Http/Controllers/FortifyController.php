<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FortifyController extends Controller
{
  // ---------------------------------------------------------------------------------------
  // Login
  // ---------------------------------------------------------------------------------------
  public function login()
  {
    return Inertia::render('Fortify/Login/Login');
  }

  // ---------------------------------------------------------------------------------------
  // Forgot password page
  // ---------------------------------------------------------------------------------------
  public function forgotPassword()
  {
    return Inertia::render('Fortify/ResetPassword/ForgotPassword');
  }

  // ---------------------------------------------------------------------------------------
  // Reset password page
  // ---------------------------------------------------------------------------------------
  public function resetPassword(Request $request)
  {
    // Get email and token from url params
    $email = $request->input('email', null);
    $token = $request->input('token', null);

    // Check if token exists
    if (!$token) abort(401);

    // Check if email exists
    $exists = User::where('email', $email)->exists();
    if (!$exists) abort(401);

    // Return reset password page
    return Inertia::render('Fortify/ResetPassword/ResetPassword', [
      'token' => $token
    ]);
  }
}
