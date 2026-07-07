<?php

namespace App\Paginators;

use App\Models\Views\UserView;
use Artibet\Laralib\Abstracts\PaginatorBase;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\User\View as UserViewResource;

class UserPaginator extends PaginatorBase
{
  // ---------------------------------------------------------------------------------------
  // Override abstract method columns()
  // ---------------------------------------------------------------------------------------
  protected function columns(): array
  {
    return [
      ['id' => 'email', 'type' => 'string'],
      ['id' => 'name', 'type' => 'string'],
      ['id' => 'is_active_label', 'type' => 'string'],
      ['id' => 'is_superadmin_label', 'type' => 'string'],
      ['id' => 'is_admin_label', 'type' => 'string'],
      ['id' => 'is_editor_label', 'type' => 'string'],
    ];
  }

  // ---------------------------------------------------------------------------------------
  // Override abstract method query()
  // ---------------------------------------------------------------------------------------
  protected function query(): Builder
  {
    return UserView::query();
  }

  // ---------------------------------------------------------------------------------------
  // Override abstract method resourceClass()
  // ---------------------------------------------------------------------------------------
  protected function resourceClass(): string
  {
    return UserViewResource::class;
  }
}
