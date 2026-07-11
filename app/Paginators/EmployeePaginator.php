<?php

namespace App\Paginators;

use Artibet\Laralib\Abstracts\PaginatorBase;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Employee\View as EmployeeViewResource;
use App\Models\Views\EmployeeView;

class EmployeePaginator extends PaginatorBase
{
  // ---------------------------------------------------------------------------------------
  // Override abstract method columns()
  // ---------------------------------------------------------------------------------------
  protected function columns(): array
  {
    return [
      ['id' => 'am', 'type' => 'string'],
      ['id' => 'lastname', 'type' => 'string'],
      ['id' => 'firstname', 'type' => 'string'],
      ['id' => 'card_no', 'type' => 'string'],
      ['id' => 'last_id', 'type' => 'date'],
      ['id' => 'last_out', 'type' => 'date'],
    ];
  }

  // ---------------------------------------------------------------------------------------
  // Override abstract method query()
  // ---------------------------------------------------------------------------------------
  protected function query(): Builder
  {
    return EmployeeView::query();
  }

  // ---------------------------------------------------------------------------------------
  // Override abstract method resourceClass()
  // ---------------------------------------------------------------------------------------
  protected function resourceClass(): string
  {
    return EmployeeViewResource::class;
  }
}
