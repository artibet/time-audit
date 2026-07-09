<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadFile extends Model
{
  protected $table = 'upload_files';
  public $timestamps = true;
  protected $guarded = [];
  protected function casts(): array
  {
    return [
      'starts_at' => 'datetime',
      'ends_at' => 'datetime',
    ];
  }
}
