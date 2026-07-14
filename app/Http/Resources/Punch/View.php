<?php

namespace App\Http\Resources\Punch;

use App\Enums\PunchDirectionEnum;
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
      'upload_file_id' => $this->upload_file_id,
      'employee_id' => $this->employee_id,
      'direction' => $this->direction,
      'direction_label' => $this->direction_label,
      'direction_color' => PunchDirectionEnum::from($this->direction)->color(),
      'clock_code' => $this->clock_code,
      'am' => $this->am,
      'lastname' => $this->lastname,
      'firstname' => $this->firstname,
      'card_no' => $this->card_no,
      'shift_string' => $this->shift_string,
      'shift_start' => $this->shift_start,
      'shift_end' => $this->shift_end,
      'punched_at' => $this->punched_at,
      'punch_year' => $this->punch_year,
      'punch_month' => $this->punch_month,
      'punch_month_name' => $this->punch_month_name,
      'punch_day' => $this->punch_day,
      'punch_hour' => $this->punch_hour,
      'punch_minute' => $this->punch_minute,
      'punch_second' => $this->punch_second,
      'punch_date_string' => $this->punch_date_string,
      'punch_time_string' => $this->punch_time_string,
    ];
  }
}
