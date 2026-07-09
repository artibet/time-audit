<?php

namespace App\Http\Controllers;

use App\Models\UploadFile;
use App\Paginators\UploadFilePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class UploadFileController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    Gate::authorize('viewAny', UploadFile::class);

    return Inertia::render('UploadFiles/Index/Index', [
      'policy' => [
        'create' => Gate::allows('create', UploadFile::class)
      ],
      'url' => [
        'store' => route('upload-files.store'),
        'ssp' => route('upload-files.ssp')
      ]
    ]);
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
    Gate::authorize('create', UploadFile::class);

    // Validate 
    $request->validate([
      'descr' => 'required',
      'file' => 'required|file'
    ]);
  }

  /**
   * Display the specified resource.
   */
  public function show(UploadFile $uploadFile)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(UploadFile $uploadFile)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, UploadFile $uploadFile)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(UploadFile $uploadFile)
  {
    //
  }

  // ---------------------------------------------------------------------------------------
  // Server side pagination table data 
  // ---------------------------------------------------------------------------------------
  public function ssp(Request $request)
  {
    Gate::authorize('viewAny', UploadFile::class);
    return (new UploadFilePaginator($request))->response();
  }
}
