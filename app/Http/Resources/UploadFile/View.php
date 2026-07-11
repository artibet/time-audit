<?php

namespace App\Http\Resources\UploadFile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class View extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'descr' => $this->descr,
      'starts_at' => $this->starts_at,
      'ends_at' => $this->ends_at,
      'file_size' => $this->file_size,
      'employees_count' => $this->employees_count,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,

      // punches are served ssp

      'url' => [
        'show' => route('upload-files.show', $this->id),
      ]
    ];
  }
}
