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

  // TODO

  // ---------------------------------------------------------------------------------------
  // Fullname
  // ---------------------------------------------------------------------------------------
  public function fullname(): string
  {
    return $this->lastname . ' ' . $this->firstname;
  }
}
