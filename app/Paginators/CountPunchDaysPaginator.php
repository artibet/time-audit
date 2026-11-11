<?php

namespace App\Paginators;

use App\Models\Views\CountPunchDaysView;
use Artibet\Laralib\Abstracts\PaginatorBase;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Punch\CountPunchDaysView as CountPunchDaysViewResource;

class CountPunchDaysPaginator extends PaginatorBase
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
      ['id' => 'days_with_1_punch', 'type' => 'number'],
      ['id' => 'days_with_2_punches', 'type' => 'number'],
      ['id' => 'days_with_3_punches', 'type' => 'number'],
      ['id' => 'days_with_over_4_punches', 'type' => 'number'],
      ['id' => 'total_worked_days', 'type' => 'number'],
    ];
  }

  // ---------------------------------------------------------------------------------------
  // Override abstract method query()
  // ---------------------------------------------------------------------------------------
  protected function query(): Builder
  {
    return CountPunchDaysView::query();
  }

  // ---------------------------------------------------------------------------------------
  // Override abstract method resourceClass()
  // ---------------------------------------------------------------------------------------
  protected function resourceClass(): string
  {
    return CountPunchDaysViewResource::class;
  }
}
