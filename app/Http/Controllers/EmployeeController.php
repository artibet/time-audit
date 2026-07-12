<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Paginators\EmployeePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use App\Http\Resources\Employee\Show as EmployeeShowResource;
use App\Models\Punch;
use App\Paginators\EmployeePunchPaginator;

class EmployeeController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    Gate::authorize('viewAny', Employee::class);

    return Inertia::render('Employees/Index/Index', [
      'policy' => [
        'create' => Gate::allows('create', Employee::class),
      ],
      'url' => [
        'store' => route('employees.store'),
        'ssp' => route('employees.ssp'),
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
    Gate::authorize('create', Employee::class);

    // validation
    $request->validate([
      'am' => 'required',
      'lastname' => 'required',
      'firstname' => 'required',
      'card_no' => 'required',
    ]);

    // Check for unique am
    $amExists = Employee::where('am', $request->am)->exists();
    if ($amExists) {
      return back()->with('error', "Ο αριμός μητρώου '{$request->email}' υπάρχει ήδη!");
    }

    // Create employee
    $employee = Employee::create([
      'am' => $request->am,
      'lastname' => $request->lastname,
      'firstname' => $request->firstname,
      'card_no' => $request->card_no,
    ]);

    // Return to show page
    return redirect()->route('employees.show', $employee->id)->with('success', 'Ο εργαζόμενος δημιουργήθηκε με επιτυχία!');
  }

  /**
   * Display the specified resource.
   */
  public function show(Employee $employee)
  {
    Gate::authorize('view', $employee);

    // breadcrumb
    $breadcrumbs = [
      ['label' => 'Εργαζόμενοι', 'url' => route('employees.index')],
      ['label' => $employee->fullname(), 'url' => null],
    ];

    return Inertia::render('Employees/Show/Show', [
      'employee' => new EmployeeShowResource($employee),
      'breadcrumbs' => $breadcrumbs
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Employee $employee)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Employee $employee)
  {
    Gate::authorize('update', $employee);

    // Get posted data
    $field = $request->field;
    $value = $request->value;

    // Έλεγχος μοναδικότητας am
    if ($field === 'email') {
      $exists = Employee::where('am', $value)->whereNot('id', $employee->id)->exists();
      if ($exists) {
        return back()->with('error', "Ο A.M. '$value' υπάρχει ήδη!");
      } else {
        $employee->$field = $value;
      }
    }

    // Any other
    else {
      $employee->$field = $value;
    }

    // Update and return back
    $employee->save();
    return back();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Employee $employee)
  {
    Gate::authorize('delete', $employee);
    $employee->delete();
    return redirect()->route('employees.index')->with('success', "Ο εργαζόμενος {$employee->fullname()} διαγράφηκε με επιτυχία!");
  }

  // ---------------------------------------------------------------------------------------
  // Server side pagination table data 
  // ---------------------------------------------------------------------------------------
  public function ssp(Request $request)
  {
    Gate::authorize('viewAny', Employee::class);
    return (new EmployeePaginator($request))->response();
  }

  // ---------------------------------------------------------------------------------------
  // Server side pagination for employee panches
  // ---------------------------------------------------------------------------------------
  public function sspPunches(Request $request, Employee $employee)
  {
    Gate::authorize('viewAny', Punch::class);
    return (new EmployeePunchPaginator($request, $employee->id))->response();
  }
}
