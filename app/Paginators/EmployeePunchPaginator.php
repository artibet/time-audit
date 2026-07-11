<?php

namespace App\Paginators;

use App\Models\Views\PunchView;
use Artibet\Laralib\Abstracts\PaginatorBase;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Punch\View as PunchViewResource;

class EmployeePunchPaginator extends PaginatorBase
{
  private int $employeeId;

  // ---------------------------------------------------------------------------------------
  // Override abstract method columns()
  // ---------------------------------------------------------------------------------------
  protected function columns(): array
  {
    return [
      ['id' => 'punch_year', 'type' => 'number'],
      ['id' => 'punch_month_name', 'type' => 'string'],
      ['id' => 'punch_day', 'type' => 'number'],
      ['id' => 'clock_code', 'type' => 'string'],
      ['id' => 'direction_label', 'type' => 'string'],
      ['id' => 'punch_time_string', 'type' => 'string'],
    ];
  }

  // ---------------------------------------------------------------------------------------
  // Override abstract method query()
  // ---------------------------------------------------------------------------------------
  protected function query(): Builder
  {
    return PunchView::where('employee_id', $this->employeeId);
  }

  // ---------------------------------------------------------------------------------------
  // Override abstract method resourceClass()
  // ---------------------------------------------------------------------------------------
  protected function resourceClass(): string
  {
    return PunchViewResource::class;
  }
}
