<?php

namespace App\Http\Controllers;

use App\Models\Punch;
use App\Paginators\CountPunchDaysPaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class PunchController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  // ---------------------------------------------------------------------------------------
  // Count days view index page
  // ---------------------------------------------------------------------------------------
  public function countPunchDays()
  {
    Gate::authorize('viewCountPunchDays', Punch::class);
    return Inertia::render('Punches/Index/CountPunchDays', [
      'url' => [
        'ssp' => route('punches.count-punch-days-ssp'),
      ]
    ]);
  }

  public function sspCountPunchDays(Request $request)
  {
    Gate::authorize('viewCountPunchDays', Punch::class);
    return (new CountPunchDaysPaginator($request))->response();
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Punch $punch)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Punch $punch)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Punch $punch)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Punch $punch)
  {
    //
  }
}
