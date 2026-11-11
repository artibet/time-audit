<?php

namespace App\Http\Resources\Punch;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountPunchDaysView extends JsonResource
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
      'am' => $this->am,
      'lastname' => $this->lastname,
      'firstname' => $this->firstname,
      'days_with_1_punch' => $this->days_with_1_punch,
      'days_with_2_punches' => $this->days_with_2_punches,
      'days_with_3_punches' => $this->days_with_3_punches,
      'days_with_4_punches' => $this->days_with_4_punches,
      'days_with_over_4_punches' => $this->days_with_over_4_punches,
      'total_worked_days' => $this->total_worked_days,
    ];
  }
}
