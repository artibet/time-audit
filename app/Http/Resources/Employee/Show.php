<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class Show extends JsonResource
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
      'fullname' => $this->fullname(),
      'card_no' => $this->card_no,
      'last_in' => $this->last_in,
      'last_out' => $this->last_out,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,

      // punches are served ssp

      'policy' => [
        'update' => Gate::allows('update', $this->resource),
        'delete' => Gate::allows('delete', $this->resource),
      ],

      'url' => [
        'ssp_punches' => route('employees.ssp-punches', $this->id),
        'update' => route('employees.update', $this->id),
        'delete' => route('employees.destroy', $this->id),
      ],
    ];
  }
}
