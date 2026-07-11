<?php

namespace App\Http\Resources\Employee;

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
      'am' => $this->am,
      'lastname' => $this->lastname,
      'firstname' => $this->firstname,
      'card_no' => $this->card_no,
      'last_in' => $this->last_in,
      'last_out' => $this->last_out,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,

      'url' => [
        'show' => route('employees.show', $this->id),
      ]
    ];
  }
}
