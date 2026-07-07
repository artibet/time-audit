<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Model;

class UserView extends Model
{
  protected $table = 'v_users';
  public $timestamps = false;
  protected $guarded = [];

  protected function casts(): array
  {
    return [
      'created_at' => 'datetime',
      'udated_at' => 'datetime',
      'is_active' => 'boolean'
    ];
  }
}
