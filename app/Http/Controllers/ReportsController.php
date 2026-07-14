<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportsController extends Controller
{
  // ---------------------------------------------------------------------------------------
  // Υπερωρίες (overtime)
  // ---------------------------------------------------------------------------------------
  public function overtime()
  {
    return Inertia::render('UnderConstructionPage', [
      'title' => 'Αναφορές - Υπερωρίες'
    ]);
  }
}
