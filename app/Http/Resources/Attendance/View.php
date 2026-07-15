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
      'punch_date' => $this->punch_date,
      'shift_start' => $this->shift_start,
      'shift_end' => $this->shift_end,
      'shift_string' => $this->shift_string,
      'punch_in' => $this->punch_in,
      'punch_out' => $this->punch_out,
      'punch_year' => $this->punch_year,
      'punch_month' => $this->punch_month,
      'punch_month_name' => $this->punch_month_name,
      'punch_day' => $this->punch_day,
      'shift_minutes' => $this->shift_minutes,
      'worked_minutes' => $this->worked_minutes,
      'work_balance_minutes' => $this->work_balance_minutes,
      'overtime_minutes' => $this->overtime_minutes,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at
    ];
  }
}
