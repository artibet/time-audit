<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    // Create spatie roles (registered in RoleEnum)
    Role::create(['name' => RoleEnum::SUPERADMIN->value, 'name_gr' => RoleEnum::from('superadmin')->label()]);
    Role::create(['name' => RoleEnum::ADMIN->value, 'name_gr' => RoleEnum::from('admin')->label()]);
    Role::create(['name' => RoleEnum::EDITOR->value, 'name_gr' => RoleEnum::from('editor')->label()]);

    // Create superadmin user
    $sotos = User::create([
      'name' => 'ΤΣΑΚΙΡΙΔΗΣ ΣΩΤΗΡΗΣ',
      'email' => 'sotiris@serres.gr',
      'password' => Hash::make('123')
    ]);
    $sotos->assignRole(RoleEnum::SUPERADMIN);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    User::where('email', 'sotiris@serres.gr')->delete();

    Role::where('name', RoleEnum::SUPERADMIN->value)->delete();
    Role::where('name', RoleEnum::ADMIN->value)->delete();
    Role::where('name', RoleEnum::EDITOR->value)->delete();
  }
};
