<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use App\Http\Resources\Role\Lookup as RoleLookupResource;
use App\Http\Resources\User\Show as UserShowResource;
use App\Paginators\UserPaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    Gate::authorize('viewAny', User::class);
    return Inertia::render('Users/Index/Index', [
      'roles' => RoleLookupResource::collection(Role::orderBy('id', 'asc')->get()),
      'policy' => [
        'create' => Gate::allows('create', User::class),
      ],
      'url' => [
        'store' => route('users.store'),
        'ssp' => route('users.ssp'),
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
    Gate::authorize('create', User::class);

    $validated = $request->validate([
      'email' => [
        'required',
        'string',
        'email',
        'max:255',
      ],
      'name' => ['required', 'string', 'max:255'],
      'roles' => ['required', 'array', 'min:1'],
      'password' => [
        'required',
        'string',
        'confirmed', // Looks for 'password_confirmation' automatically
        Password::min(4)
      ],
    ], [
      // Custom Greek messages to match your Yup UI
      'email.required' => 'Καταχωρήστε το email του χρήστη.',
      'email.email' => 'Μη έγκυρη μορφή Email.',
      'password.confirmed' => 'Οι κωδικοί δεν ταιριάζουν.',
      'password' => 'Ο κωδικός πρέπει να είναι τουλάχιστον 4 χαρακτήρες.',
    ]);

    // Check for unique email
    $emailExists = User::where('email', $validated['email'])->exists();
    if ($emailExists) {
      $email = $validated['email'];
      return back()->with('error', "Το email '$email' υπάρχει ήδη!");
    }

    // Create the user
    $user = User::create([
      'email' => $validated['email'],
      'name' => $validated['name'],
      'password' => Hash::make($validated['password']),
    ]);

    // Attach the roles
    $user->roles()->sync($validated['roles']);

    // Return to show page
    return redirect()->route('users.show', $user->id)->with('success', 'Ο Χρήστης δημιουργήθηκε με επιτυχία!');
  }

  /**
   * Display the specified resource.
   */
  public function show(User $user)
  {
    Gate::authorize('view', $user);

    // breadcrumb
    $breadcrumbs = [
      ['label' => 'Χρήστες', 'url' => route('users.index')],
      ['label' => $user->name, 'url' => null],
    ];

    return Inertia::render('Users/Show/Show', [
      'user' => new UserShowResource($user),
      'roles' => RoleLookupResource::collection(Role::orderBy('id', 'asc')->get()),
      'breadcrumbs' => $breadcrumbs
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(User $user)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, User $user)
  {
    Gate::authorize('update', $user);

    // Get posted data
    $field = $request->field;
    $value = $request->value;

    // Έλεγχος δικαιωμάτων για μεταβολή κατάστασης
    if ($field === 'is_active') {
      Gate::authorize('updateStatus', $user);
      $user->$field = $value;
    }

    // Έλεγχος μοναδικότητας email
    else if ($field === 'email') {
      $exists = User::where('email', $value)->whereNot('id', $user->id)->exists();
      if ($exists) {
        return back()->with('error', "Το email '$value' υπάρχει ήδη!");
      } else {
        $user->$field = $value;
      }
    }

    // Ειδική διαχείριση ρόλων
    else if ($field === 'roles') {
      Gate::authorize('updateRoles', $user);
      $user->roles()->sync($value);
    }

    // Any other
    else {
      $user->$field = $value;
    }

    // Update and return
    $user->save();
    return back();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $user)
  {
    Gate::authorize('delete', $user);
    $user->delete();
    return redirect()->route('users.index')->with('success', "Ο Χρήστης {$user->name} διαγράφηκε με επιτυχία!");
  }

  // ---------------------------------------------------------------------------------------
  // Server side pagination table data 
  // ---------------------------------------------------------------------------------------
  public function ssp(Request $request)
  {
    Gate::authorize('viewAny', User::class);
    return (new UserPaginator($request))->response();
  }

  // ---------------------------------------------------------------------------------------
  // Reset password by superadmins
  // ---------------------------------------------------------------------------------------
  public function resetPassword(Request $request, User $user)
  {
    Gate::authorize('resetPassword', $user);

    $request->validate([
      'password' => 'required'
    ]);

    $user->password = Hash::make($request->password);
    $user->save();

    return back()->with('success', 'Ο κωδικός πρόσβασης του χρήστη άλλαξε με επιτυχία');
  }
}
