<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class RootController extends Controller
{
  // ---------------------------------------------------------------------------------------
  // Landing page
  // ---------------------------------------------------------------------------------------
  public function root()
  {
    return Inertia::render('Test');
  }
}
