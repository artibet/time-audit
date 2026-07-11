<?php

namespace App\Http\Controllers;

use App\Models\UploadFile;
use App\Paginators\UploadFilePaginator;
use App\Services\UploadFileService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    $processor = new UploadFileService();

    // Validate 
    $request->validate([
      'descr' => 'required',
      'file' => 'required|file'
    ]);

    // Process the file
    try {
      $data = $processor->process($request->file->getPathname());
      dd($data);
    } catch (Exception $e) {
      return back()->with('error', $e->getMessage());
    }

    // Insert
    try {

      // Create the master recored
      $uploadFile = UploadFile::create([
        'descr' => $request->descr,
        'starts_at' => $data['starts_at'],
        'ends_at' => $data['ends_at'],
        'employees_count' => $data['employees_count']
      ]);

      // Upload the file and set the file_size
      $media = $uploadFile->addMediaFromRequest('file')->toMediaCollection('file');
      $uploadFile->update([
        'file_size' => $media->size
      ]);

      // Εισαγωγή των γραμμών στον πίνακα upload_file_rows
      // TODO

      // Commit and return to show page
      DB::commit();
      return redirect()->route('upload-files.show', $uploadFile->id)->with('success', 'Το αρχείο κινήσεων εισήχθη με επιτυχία!');
    } catch (Exception $e) {
      if (isset($media)) {
        $media->delete();
        return back()->with('error', 'Σφάλμα κατά την αποθήκευση: ' . $e->getMessage());
      }
    }
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
