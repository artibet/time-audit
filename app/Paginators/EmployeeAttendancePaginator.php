<?php

namespace App\Paginators;

use Artibet\Laralib\Abstracts\PaginatorBase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Resources\Attendance\View as AttendanceViewResource;
use App\Models\Views\AttentanceView;

class EmployeeAttendancePaginator extends PaginatorBase
{
  private int $employeeId;

  // ---------------------------------------------------------------------------------------
  // Override constructor to get employee_id
  // ---------------------------------------------------------------------------------------
  public function __construct(Request $request, int $employeeId)
  {
    parent::__construct($request);
    $this->employeeId = $employeeId;
  }


  // ---------------------------------------------------------------------------------------
  // Override abstract method columns()
  // ---------------------------------------------------------------------------------------
  protected function columns(): array
  {
    return [
      ['id' => 'punch_year', 'type' => 'number'],
      ['id' => 'punch_month_name', 'type' => 'string'],
      ['id' => 'punch_day', 'type' => 'number'],
      ['id' => 'shift_string', 'type' => 'string'],
      ['id' => 'punch_in', 'type' => 'date'],
      ['id' => 'punch_out', 'type' => 'date'],
      ['id' => 'shift_minutes', 'type' => 'number', 'footer' => ['type' => 'sum', 'format' => 'integer']],
      ['id' => 'worked_minutes', 'type' => 'number', 'footer' => ['type' => 'sum', 'format' => 'integer']],
      ['id' => 'work_balance_minutes', 'type' => 'number', 'footer' => ['type' => 'sum', 'format' => 'integer']],
      ['id' => 'overtime_minutes', 'type' => 'number', 'footer' => ['type' => 'sum', 'format' => 'integer']],
    ];
  }

  // ---------------------------------------------------------------------------------------
  // Override abstract method query()
  // ---------------------------------------------------------------------------------------
  protected function query(): Builder
  {
    return AttentanceView::where('employee_id', $this->employeeId);
  }

  // ---------------------------------------------------------------------------------------
  // Override abstract method resourceClass()
  // ---------------------------------------------------------------------------------------
  protected function resourceClass(): string
  {
    return AttendanceViewResource::class;
  }
}
