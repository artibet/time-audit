<?php

namespace App\Http\Resources\Attendance;

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
      'employee_id' => $this->employee_id,
      'lastname' => $this->lastname,
      'firstname' => $this->firstname,
      'shift_start' => $this->shift_start,
      'shift_end' => $this->shift_end,
      'punch_year' => $this->punch_year,
      'punch_month' => $this->punch_month,
      'punch_day' => $this->punch_day,
      'punch_month_name' => $this->punch_month_name,
      'punch_date_string' => $this->punch_date_string,
      'punch_in' => $this->punch_in,
      'punch_out' => $this->punch_out,
      'shift_minutes' => $this->shift_minutes,
      'worked_minutes' => $this->worked_minutes,
      'overtime_minutes' => $this->overtime_minutes
    ];
  }
}
