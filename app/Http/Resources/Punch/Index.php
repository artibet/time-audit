<?php

namespace App\Http\Resources\Punch;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Index extends JsonResource
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
      'upload_file_id' => $this->upload_file_id,
      'employee_id' => $this->employee_id,
      'direction' => $this->direction->resource(),
      'clock_code' => $this->clock_code,
      'am' => $this->am,
      'lastname' => $this->lastname,
      'firstname' => $this->firstname,
      'card_no' => $this->card_no,
      'shift_string' => $this->shift_string,
      'shift_start' => $this->shift_start,
      'shift_end' => $this->shift_end,
      'punched_at' => $this->punched_at,
    ];
  }
}
