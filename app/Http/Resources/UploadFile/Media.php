<?php

namespace App\Http\Resources\UploadFile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Media extends JsonResource
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
      'file_name' => $this->file_name,
      'name' => $this->name,
      'extension' => $this->extension,
      'mime_type' => $this->mime_type,
      'human_readable_size' => $this->human_readable_size,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,

      'url' => [
        'download' => route('upload-files.download-media', $this->model_id),
      ]
    ];
  }
}
