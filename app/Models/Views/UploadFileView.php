<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Model;

class UploadFileView extends Model
{
  protected $table = 'v_upload_files';
  public $timestamps = false;
  protected $guarded = [];
  protected function casts(): array
  {
    return [
      'starts_at' => 'datetime',
      'ends_at' => 'datetime',
    ];
  }
}
