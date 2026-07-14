<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
  protected $table = 'employees';
  public $timestamps = true;
  protected $guarded = [];

  protected function casts(): array
  {
    return [
      'last_in' => 'datetime',
      'last_out' => 'datetime',
    ];
  }

  // ---------------------------------------------------------------------------------------
  // Relations
  // ---------------------------------------------------------------------------------------

  // punches
  public function punches()
  {
    return $this->hasMany(Punch::class, 'employee_id', 'id');
  }

  // attendances
  public function attendances()
  {
    return $this->hasMany(Attendance::class, 'employee_id', 'id');
  }

  // ---------------------------------------------------------------------------------------
  // Fullname
  // ---------------------------------------------------------------------------------------
  public function fullname(): string
  {
    return $this->lastname . ' ' . $this->firstname;
  }
}
