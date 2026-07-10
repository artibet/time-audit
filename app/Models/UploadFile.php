<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class UploadFile extends Model implements HasMedia
{
  use InteractsWithMedia;

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

  // ---------------------------------------------------------------------------------------
  // Register media collection
  // ---------------------------------------------------------------------------------------
  public function registerMediaCollections(): void
  {
    $this->addMediaCollection('file')
      ->useDisk('media_private')
      ->singleFile();
  }
}
